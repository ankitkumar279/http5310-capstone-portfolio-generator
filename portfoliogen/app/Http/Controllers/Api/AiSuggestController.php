<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AiSuggestController extends Controller
{
    public function suggest(Request $request)
    {
        $v = Validator::make($request->all(), [
            'type' => 'required|string',
            'text' => 'nullable|string|max:3000',
            'context' => 'nullable|array',
        ]);

        if ($v->fails()) {
            return response()->json(['ok' => false, 'errors' => $v->errors()], 422);
        }

        $type = $request->input('type');
        $text = (string) $request->input('text', '');
        $ctx  = (array) $request->input('context', []);

        $jobTitle = $ctx['job_title'] ?? 'professional';

        $prompt = $this->buildPrompt($type, $text, $jobTitle);

        $key = config('openai.key');
        $model = config('openai.model');

        if (!$key) {
            return response()->json(['ok' => false, 'error' => 'Missing OPENAI_API_KEY'], 500);
        }

        $res = Http::timeout(25)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $key,
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You write clean modern portfolio content. No emojis. Output JSON only.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);

        if (!$res->ok()) {
            return response()->json([
                'ok' => false,
                'error' => 'OpenAI request failed',
                'status' => $res->status(),
                'details' => $res->json(),
            ], 500);
        }

        $raw = data_get($res->json(), 'choices.0.message.content', '');
        $suggestions = $this->extractSuggestions($raw);

        return response()->json([
            'ok' => true,
            'suggestions' => $suggestions,
        ]);
    }

    private function buildPrompt(string $type, string $text, string $jobTitle): string
    {
        return match ($type) {
           'bio' =>
           "Generate exactly 3 improved portfolio bios for a {$jobTitle}.
Rewrite the following portfolio bio to make it more professional and impactful.
Keep it 4-5 sentences.
Return ONLY the improved text.
Do NOT return JSON.
Do NOT use brackets or formatting.
should give three option in text separated by new lines.
Format:
[\"bio 1\",\"bio 2\",\"bio 3\"]
Existing:
{$text}",
            'project' =>
                "Generate exactly 3 improved project descriptions (2-4 strong sentences each). Output ONLY JSON array Do NOT use brackets or formatting Return ONLY the improved text.\n\nExisting:\n{$text}",

            'experience' =>
                "Generate exactly 3 strong work experience descriptions (3-5 achievement-focused sentences each). Output ONLY JSON array Do NOT use brackets or formatting Return ONLY the improved text.\n\nExisting:\n{$text}",

            'skills' =>
                "Generate exactly 3 comma-separated skill sets (8-12 skills each) relevant to {$jobTitle}. Output ONLY JSON array Do NOT use brackets or formatting Return ONLY the improved text.\n\nExisting:\n{$text}",

            'job_title' =>
                "Return exactly 8 job title suggestions as JSON array based on: {$text}",

            'company' =>
                "Return exactly 8 company name suggestions as JSON array based on: {$text}",

            'project_title' =>
                "Return exactly 8 project title suggestions as JSON array based on: {$text}",

            default =>
                "Return exactly 3 suggestions as JSON array based on: {$text}",
        };
    }

    private function extractSuggestions(string $raw, int $limit = 3): array
{
    $raw = trim($raw);
    $raw = preg_replace('/^```(?:json)?\s*|\s*```$/m', '', $raw);

    $decoded = json_decode($raw, true);

    if (is_array($decoded)) {
        $out = [];

        foreach ($decoded as $item) {
            if (is_string($item)) {
                $out[] = $item;
            } elseif (is_array($item)) {
                if (isset($item['text']) && is_string($item['text'])) {
                    $out[] = $item['text'];
                } elseif (isset($item['title']) && is_string($item['title'])) {
                    $out[] = $item['title'];
                } elseif (isset($item['value']) && is_string($item['value'])) {
                    $out[] = $item['value'];
                } else {
                    $out[] = json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                }
            } else {
                $out[] = (string) $item;
            }
        }

        $out = array_values(array_filter(array_map('trim', $out)));
        return array_slice($out, 0, $limit);
    }

    $lines = preg_split("/\r\n|\n|\r/", $raw);
    $lines = array_values(array_filter(array_map('trim', $lines)));
    return array_slice($lines, 0, $limit);
}
}