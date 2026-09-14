<?php
$token = $_GET['token'] ?? '';
?><!doctype html>
<html lang="pt-BR"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Localizador em Tempo Real</title><link rel="stylesheet" href="style.css">
<?php if($token): ?><link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"><?php endif; ?>
</head><body><main class="wrap"><section class="card">
<div class="badge">📍 LOCALIZADOR V2</div>
<h1><?= $token ? 'Acompanhar localização' : 'Criar compartilhamento' ?></h1>
<?php if(!$token): ?>
<p>Crie uma sessão e envie o link para a pessoa que vai compartilhar o GPS.</p>
<button id="create">🔗 Criar link</button><div id="result"></div>
<?php else: ?>
<p>Esta página acompanha somente a localização que foi autorizada pelo outro dispositivo.</p>
<div id="status">Conectando...</div><div id="map"></div>
<div class="coords"><span>Latitude <b id="lat">—</b></span><span>Longitude <b id="lon">—</b></span><span>Precisão <b id="acc">—</b></span></div>
<?php endif; ?>
<p class="note">🔐 O sistema não localiza ninguém pelo número de telefone. O compartilhamento depende de autorização do usuário.</p>
</section></main>
<script>window.SHARE_TOKEN=<?= json_encode($token) ?>;</script>
<?php if($token): ?><script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script><?php endif; ?>
<script src="app.js"></script></body></html>
