## basic-chat

**Como instalar**
Imagem esta disponível no **Docker hub**  `wladsonlima/basic-chat`
 
 -  Crie um container:
  `docker run -d --name=chat -p 8000:8000 wladsonlima/basic-chat` 
 
 - Instale o bash:
  `docker exec -it chat apk add bash`
 - Acesse o bash 
 `docker exec -it chat bash`
 - Execute o servidor do PHP 
  `php bin/console serve:run 0.0.0.0:8000`

Pronto agora acesse localhost:8000

### Routes

* Acesse a `**/**` para acesso do cliente 
* Acesse a `**/pa**` para acesso do atendente  
* Documentação API `**/api**`
