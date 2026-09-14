```php
<?php
header('Content-Type: application/json; charset=utf-8');

$dsn = getenv('DATABASE_URL');

if (!$dsn) {
    http_response_code(500);
    echo json_encode(['error' => 'DATABASE_URL não configurada.']);
    exit;
}

try {
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("
        CREATE TABLE IF NOT EXISTS sessions (
            token VARCHAR(64) PRIMARY KEY,
            created_at BIGINT NOT NULL,
            active BOOLEAN DEFAULT TRUE,
            lat DOUBLE PRECISION,
            lon DOUBLE PRECISION,
            accuracy DOUBLE PRECISION,
            updated_at BIGINT
        )
    ");

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erro no banco: ' . $e->getMessage()
    ]);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'create') {
    $token = bin2hex(random_bytes(24));

    $q = $db->prepare("
        INSERT INTO sessions(token, created_at, active)
        VALUES(?, ?, TRUE)
    ");

    $q->execute([$token, time()]);

    echo json_encode(['token' => $token]);
    exit;
}

$token = $_POST['token'] ?? $_GET['token'] ?? '';

if (!preg_match('/^[a-f0-9]{48}$/', $token)) {
    http_response_code(400);
    echo json_encode(['error' => 'Token inválido']);
    exit;
}

if ($action === 'update') {

    $lat = (float)($_POST['lat'] ?? 999);
    $lon = (float)($_POST['lon'] ?? 999);
    $acc = (float)($_POST['accuracy'] ?? 0);

    if ($lat < -90 || $lat > 90 || $lon < -180 || $lon > 180) {
        http_response_code(400);
        echo json_encode(['error' => 'Coordenadas inválidas']);
        exit;
    }

    $q = $db->prepare("
        UPDATE sessions
        SET lat=?, lon=?, accuracy=?, updated_at=?, active=TRUE
        WHERE token=?
    ");

    $q->execute([
        $lat,
        $lon,
        $acc,
        time(),
        $token
    ]);

    echo json_encode([
        'ok' => $q->rowCount() > 0
    ]);

    exit;
}

if ($action === 'stop') {

    $q = $db->prepare(
        "UPDATE sessions SET active=FALSE WHERE token=?"
    );

    $q->execute([$token]);

    echo json_encode(['ok' => true]);
    exit;
}

if ($action === 'get') {

    $q = $db->prepare("
        SELECT active, lat, lon, accuracy, updated_at
        FROM sessions
        WHERE token=?
    ");

    $q->execute([$token]);

    $r = $q->fetch(PDO::FETCH_ASSOC);

    if (!$r) {
        http_response_code(404);
        echo json_encode([
            'error' => 'Sessão não encontrada'
        ]);
        exit;
    }

    echo json_encode($r);
    exit;
}

http_response_code(400);

echo json_encode([
    'error' => 'Ação inválida'
]);

