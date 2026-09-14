# Localizador em Tempo Real — V2

Projeto para **compartilhamento voluntário de localização** entre dois celulares.

## Publicação no Render

1. Crie um repositório no GitHub e envie todos os arquivos desta pasta.
2. No Render, crie um **Blueprint** apontando para o repositório.
3. O `render.yaml` cria o Web Service e o PostgreSQL.
4. O Render fornece HTTPS automaticamente.
5. Abra a URL pública.
6. Crie uma sessão e copie o link A para o dispositivo que vai compartilhar.
7. Use o link B no dispositivo que vai acompanhar.

## Observações

- Não existe rastreamento por número de telefone.
- O Celular A precisa autorizar a geolocalização no navegador.
- A atualização do mapa ocorre aproximadamente a cada 3 segundos.
- O banco guarda somente a posição atual da sessão neste protótipo.
- O plano gratuito do banco/serviço pode ter limitações e mudanças de disponibilidade. Consulte a documentação do Render antes de uso contínuo.
- Para produção, adicione autenticação, expiração dos tokens, HTTPS (já fornecido pelo Render), rate limiting e políticas de retenção de dados.
