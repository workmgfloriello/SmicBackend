# SmicBackend API Documentation

## Panoramica
Questo documento descrive gli endpoint dell'API del progetto `SmicBackend`, inclusi metodi HTTP, parametri di richiesta e formati di risposta.

Base URL:
- `http://localhost/SmicBackend`
- Tutti gli endpoint sono gestiti dal file `index.php` tramite il parametro query string `api`.

---

## Endpoint

### 1) Register
- URL: `http://localhost/SmicBackend?api=register`
- Metodo: `POST`
- Headers:
  - `Content-Type: application/json`
- Corpo JSON richiesto:
  ```json
  {
    "email": "user@example.com",
    "password": "password123",
    "name": "Nome Cognome",
    "address": "Via Esempio 1",
    "phone": "1234567890"
  }
  ```
- Funzionalità:
  - crea un nuovo utente nella tabella `users`
  - salva il `uuid`, la password hashata e gli altri campi
- Risposta:
  - la funzione `sendData()` restituisce generalmente `true` o `false` in base all'inserimento nel database

### 2) Login
- URL: `http://localhost/SmicBackend?api=login`
- Metodo: `POST`
- Headers:
  - `Content-Type: application/json`
- Corpo JSON richiesto:
  ```json
  {
    "email": "user@example.com",
    "password": "password123"
  }
  ```
- Comportamento:
  - accetta `email` o `username` come campo di accesso
  - verifica la password usando `PasswordManager.php`
  - genera un token casuale con `tokenManager.php`
  - salva il token nel campo `token` dell'utente
  - imposta un cookie `auth_token` con valore `token|uuid`
- Risposta di successo:
  ```json
  {
    "success": true,
    "user": {
      "uuid": "...",
      "email": "user@example.com"
    }
  }
  ```
- Errori possibili:
  - metodo diverso da POST -> `405`
  - dati mancanti -> `400`
  - utente non trovato
  - password errata

> Nota: il file `Auth/login.php` attualmente stampa una riga di debug `API: login, Method: POST` prima del JSON. Questo può invalidare la risposta JSON se non viene rimosso.

### 3) Profile
- URL: `http://localhost/SmicBackend?api=profile`
- Metodo: `POST`
- Headers:
  - `Content-Type: application/json`
  - Cookie: `auth_token` deve essere presente
- Funzionalità:
  - verifica il cookie `auth_token` usando `verifyToken()`
  - controlla che il token esista nella tabella `users`
  - restituisce i dati profilo dell'utente loggato (`email`, `name`, `address`, `phone`)
- Risposta di successo:
  ```json
  {
    "success": true,
    "profile": {
      "data": [
        {
          "email": "user@example.com",
          "name": "Nome Cognome",
          "address": "Via Esempio 1",
          "phone": "1234567890"
        }
      ]
    }
  }
  ```
- Risposta di errore:
  ```json
  {
    "success": false,
    "message": "Token non valido"
  }
  ```
- Codice di stato: `401` se il token non è valido o mancante

> Nota: il file `Auth/profile.php` stampa anche `API: profile, Method: POST` prima del JSON.

### 4) Products
- URL: `http://localhost/SmicBackend?api=products`
- Metodi supportati: `GET`, `POST`

#### 4.1) Lista prodotti
- Metodo: `GET`
- Parametri query opzionali:
  - `category` - filtra i prodotti per categoria
- Esempio:
  - `http://localhost/SmicBackend?api=products`
  - `http://localhost/SmicBackend?api=products&category=Gelati`
- Risposta:
  ```json
  [
    {
      "id": 1,
      "name": "Gelato alla vaniglia",
      "price": "3.50",
      "available": 1,
      "category": "Gelati"
    }
  ]
  ```

#### 4.2) Aggiungi prodotto
- Metodo: `POST`
- Headers:
  - `Content-Type: application/json`
- Corpo JSON richiesto:
  ```json
  {
    "name": "Torta al cioccolato",
    "price": "5.00",
    "available": true,
    "category": "Dolci"
  }
  ```
- Comportamento:
  - salva un nuovo prodotto nella tabella `products`
  - il campo `available` è convertito in `1` o `0`
- Risposta di successo:
  ```json
  {
    "success": true
  }
  ```

---

## Note sul database
- Configurazione database in `config/dbConfig.php`
- Database: `my_smiccafe`
- Funzioni chiave:
  - `getConnection()`
  - `sendData($table, $data, $filters = [])`
  - `getData($table, $filters = [], $parameter = "*")`
- `sendData()` effettua un `INSERT` se non vengono passati filtri e un `UPDATE` se vengono passati filtri.
- `getData()` restituisce tutti i record se non ci sono filtri, altrimenti filtra con `WHERE`.

---

## Avvio e test rapido
1. Metti il progetto in `htdocs` di XAMPP.
2. Avvia Apache e MySQL.
3. Importa lo schema del database `my_smiccafe` con le tabelle `users` e `products`.
4. Esegui le richieste con Postman, curl o fetch.

### Esempio curl
```bash
curl -X POST "http://localhost/SmicBackend?api=register" \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password123","name":"Mario Rossi","address":"Via Roma 1","phone":"0123456789"}'
```

```bash
curl -X GET "http://localhost/SmicBackend?api=products&category=Gelati"
```

---

## Consigli di miglioramento
- rimuovere i messaggi di debug `echo "API: ..."` in `Auth/login.php` e `Auth/profile.php`
- aggiungere una gestione degli errori JSON più consistente
- proteggere `products` con autenticazione se necessario
- utilizzare header CORS se l'API deve essere chiamata da frontend esterni
