<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProfileEditTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // CSRFトークンの検証を無効化
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function it_updates_profile_successfully()
    {
        // 認証されたユーザーを作成
        $user = User::factory()->create();

        // ユーザーをログイン
        $this->actingAs($user);

        // テスト用の画像ファイルを作成
        Storage::fake('public');
        $image = UploadedFile::fake()->image('profile.jpg');

        // プロフィール情報を更新
        $response = $this->put(route('edit.profile'), [
            '_token' => csrf_token(), // CSRFトークンを含める
            'name' => 'テスト一郎',
            'post' => '1300012',
            'address' => '東京都墨田区太平1-2-3',
            'building' => '渋谷ビル',
            'image' => $image,
        ]);

        // 正常にリダイレクトされることを確認
        $response->assertRedirect('/profile');

        // データベースに新しいプロフィール情報が保存されていることを確認
        $user->refresh(); // ユーザー情報を再読み込み
        $this->assertEquals('テスト一郎', $user->name);
        $this->assertEquals('1300012', $user->post);
        $this->assertEquals('東京都墨田区太平1-2-3', $user->address);
        $this->assertEquals('渋谷ビル', $user->building);
        Storage::disk('public')->assertExists('images/profile.jpg');

        $user->delete();
    }

    /** @test */
    public function it_shows_validation_errors()
    {
        // 認証されたユーザーを作成
        $user = User::factory()->create();

        // ユーザーをログイン
        $this->actingAs($user);

        // 無効なデータでフォームを送信
        $response = $this->put(route('edit.profile'), [
            'name' => '', // 無効なデータ
            'post' => '123', // 無効なデータ
            'address' => '', // 無効なデータ
            'building' => str_repeat('a', 51), // 無効なデータ
        ]);

        // レスポンスがエラーメッセージを含むことを確認
        $response->assertStatus(302); // リダイレクトの確認
        $response->assertSessionHasErrors([
            'name',
            'post',
            'address',
            'building',
        ]);

        // リダイレクト後のページでエラーメッセージが表示されていることを確認
        $response = $this->get(route('edit.profile'));
        $response->assertSee('ユーザー名は必須です。');
        $response->assertSee('郵便番号は7桁の数字でなければなりません。');
        $response->assertSee('住所は必須です。');
        $response->assertSee('建物名は最大50文字でなければなりません。');

        $user->delete();
    }
}
