<?php
$token=$_GET['token']??'';
?><!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Compartilhar GPS</title><link rel="stylesheet" href="style.css"></head><body><main class="wrap"><section class="card">
<div class="badge">📱 CELULAR A</div><h1>Compartilhar meu GPS</h1>
<p>Ao tocar no botão, seu navegador pedirá permissão para compartilhar sua localização.</p>
<button id="start">📍 Autorizar e compartilhar</button><button id="stop" class="secondary" disabled>⛔ Parar compartilhamento</button>
<div id="status">Aguardando sua autorização.</div><div class="coords"><span>Latitude <b id="lat">—</b></span><span>Longitude <b id="lon">—</b></span></div>
<p class="note">Você pode parar o compartilhamento a qualquer momento.</p></section></main>
<script>window.SHARE_TOKEN=<?= json_encode($token) ?>;</script><script src="share.js"></script></body></html>
