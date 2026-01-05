@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
  <main class="container">
    <h1 class="page-title page-title">Contact</h1>

    <form class="contact-form" method="POST" action="/confirm" novalidate>
      @csrf
      {{-- お名前 --}}
      <div class="form-row">
        <div class="form-label">
          お名前 <span class="req">※</span>
        </div>
        <div class="form-field two-cols">
          <div class="field-item">
            <input type="text" name="last_name" class="input" placeholder="例: 山田" value="{{ old('last_name') }}">
            @error('last_name')
              <p class="error-message">{{ $message }}</p>
            @enderror
          </div>
          <div class="field-item">
            <input type="text" name="first_name" class="input" placeholder="例: 太郎" value="{{ old('first_name') }}">
            @error('first_name')
              <p class="error-message">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      {{-- 性別 --}}
      <div class="form-row">
        <div class="form-label">
          性別 <span class="req">※</span>
        </div>
        <div class="form-field">
          <div class="radio-group">
            <label class="radio">
              <input type="radio" name="gender" value="1"
              {{ old('gender') == '1' ? 'checked' : '' }}>
              <span>男性</span>
            </label>

            <label class="radio">
              <input type="radio" name="gender" value="2"
              {{ old('gender') == '2' ? 'checked' : '' }}>
              <span>女性</span>
            </label>

            <label class="radio">
              <input type="radio" name="gender" value="3"
              {{ old('gender') == '3' ? 'checked' : '' }}>
              <span>その他</span>
            </label>
          </div>
          @error('gender')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- メールアドレス --}}
      <div class="form-row">
        <div class="form-label">
          メールアドレス <span class="req">※</span>
        </div>
        <div class="form-field">
          <input type="email" name="email" class="input" placeholder="例: test@example.com" value="{{ old('email') }}">
          @error('email')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- 電話番号（3分割） --}}
      <div class="form-row">
        <div class="form-label">
          電話番号 <span class="req">※</span>
        </div>
        <div class="form-field">
          <div class="tel-group">
            @php
              $tel = old('tel') ?? ($contact['tel'] ?? '');
              [$tel1, $tel2, $tel3] = array_pad(explode('-', $tel), 3, '');
            @endphp
            <div class="tel-item">
              <input type="text" name="tel1" class="input tel" placeholder="080" value="{{ $tel1 }}">
              @error('tel1')
              <p class="error-message">{{ $message }}</p>
              @enderror
            </div>
            <span class="hyphen">-</span>
            <div class="tel-item">
              <input type="text" name="tel2" class="input tel" placeholder="1234" value="{{ $tel2 }}">
                @error('tel2')
                  <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
              <span class="hyphen">-</span>
            <div class="tel-item">
              <input type="text" name="tel3" class="input tel" placeholder="5678" value="{{ $tel3 }}">
                @error('tel3')
                  <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
          </div>
        </div>
      </div>

      {{-- 住所 --}}
      <div class="form-row">
        <div class="form-label">
          住所 <span class="req">※</span>
        </div>
        <div class="form-field">
          <input type="text" name="address" class="input" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
          @error('address')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>
      </div>

      {{-- 建物名 --}}
      <div class="form-row">
        <div class="form-label">
          建物名
        </div>
        <div class="form-field">
          <input type="text" name="building" class="input" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}">
        </div>
      </div>

      {{-- お問い合わせの種類 --}}
      <div class="form-row">
        <div class="form-label">
          お問い合わせの種類 <span class="req">※</span>
        </div>
        <div class="form-field">
          <select name="category_id" class="select" required>
            <option value="" disabled selected hidden>選択してください</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" {{ (string)old('category_id') == (string)$category->id ? 'selected' : '' }}>
                {{ $category->content }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>
      </div>
      {{-- お問い合わせ内容 --}}
      <div class="form-row">
        <div class="form-label">
          お問い合わせ内容 <span class="req">※</span>
        </div>
        <div class="form-field">
          <textarea name="detail" class="textarea" placeholder="お問い合わせ内容をご記載ください">
            {{ old('detail') }}
          </textarea>
          @error('detail')
            <p class="error-message">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn">確認画面</button>
      </div>

    </form>
  </main>
@endsection

