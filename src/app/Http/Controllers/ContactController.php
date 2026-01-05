<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            return redirect('/')->withInput($request->all());
        }
        $categories = Category::all();
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $date = $request->only([
            'category_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel1',
            'tel2',
            'tel3',
            'address',
            'building',
            'detail',
        ]);

        $date['tel'] = implode('', array_filter([
            $request->tel1,
            $request->tel2,
            $request->tel3,
        ],  fn ($v) => $v !== null && $v !== ''));

        unset($date['tel1'], $date['tel2'], $date['tel3']);

        $category = Category::find($request->category_id);

        return view('confirm', [
            'contact' => $date,
            'category' => $category,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->only([
            'category_id',
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'detail',
        ]);

        Contact::create($data);

        return view('thanks');
    }


}