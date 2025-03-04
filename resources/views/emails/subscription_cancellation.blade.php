<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancelamento de Inscrição</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #c0392b;
            font-size: 24px;
            margin-bottom: 10px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            font-size: 16px;
            margin-bottom: 8px;
        }
        .details {
            background-color: #ecf0f1;
            padding: 10px;
            border-radius: 6px;
        }
        .status {
            font-weight: bold;
            color: #e74c3c;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #7f8c8d;
        }
        .button {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
        }
        .button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Olá, {{ $subscription->user->name }}!</h1>
        <p>Sua inscrição foi cancelada.</p>

        <p><strong>Detalhes do evento:</strong></p>
        <div class="details">
            <ul>
                <li><strong>Evento:</strong> {{ $subscription->event->title }}</li>
                <li><strong>Data:</strong> {{ \Carbon\Carbon::parse($subscription->event->start_date)->format('d/m/Y') }}</li>
                <li><strong>Horário:</strong> {{ \Carbon\Carbon::parse($subscription->event->start_date)->format('H:i') }}</li>
                <li><strong>Local:</strong> {{ $subscription->event->location }}</li>
            </ul>
        </div>

        <p>Se foi um engano, você pode se inscrever novamente acessando o evento.</p>

        <a href="{{ url('/login') }}" class="button">Ver Eventos Disponíveis</a>

        <div class="footer">
            <p>Se você não solicitou esse cancelamento, entre em contato com nosso suporte imediatamente.</p>
            <p>Equipe Teste Budmol</p>
        </div>
    </div>

</body>
</html>
