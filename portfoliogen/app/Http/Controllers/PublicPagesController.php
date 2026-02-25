<?php

namespace App\Http\Controllers;

class PublicPagesController extends Controller
{
  public function home() { return view('public.home'); }
  public function how() { return view('public.how'); }
  public function templates() { return view('public.templates'); }
}