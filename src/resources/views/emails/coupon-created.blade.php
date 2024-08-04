<!DOCTYPE html>
<html>
<head>
    <title>クーポンが発行されました</title>
</head>
<body>
    <h1>新しいクーポンが発行されました！</h1>
    <p>クーポンコード: {{ $couponCode }}</p>
    <p>割引率: {{ $discount }}%</p>
    <p>使用期限: {{ $expiresAt ? $expiresAt->format('Y-m-d H:i') : 'なし' }}</p>
    <p><a href="{{ url('/login') }}" class="button">ログイン</a></p>
</body>
</html>
