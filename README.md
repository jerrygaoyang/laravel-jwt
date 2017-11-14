# jwt

### 使用说明
```
use Jerry/JWT/JWT;

$secret = "1234567890";

$payload = [
  "user_id" => 1
];

$token = JWT::encode($payload, $secret);
print $token;

echo "<br>";

$payload = JWT::decode($token, $secret);
var_dump($payload);

```
