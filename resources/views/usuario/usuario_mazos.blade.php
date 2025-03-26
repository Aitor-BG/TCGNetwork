<x-app-layout>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mazos</title>
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>

    <body>

        <div class="container text-center">
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <div class="card text-center" style="width: 18rem;">
                        <img src="{{ asset('images/logo_op.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">One Piece TCG</h5>
                            <a href="/usuario/decksOP" class="btn btn-primary">Ver Mazos</a>
                        </div>
                    </div>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="card text-center" style="width: 18rem;">
                        <img src="{{ asset('images/logo_pk.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Dragon Ball: Fusion World</h5>
                            <a href="/usuario/decks" class="btn btn-primary">Ver Mazos</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <div class="card text-center" style="width: 18rem;">
                        <img src="{{ asset('images/logo_op.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Digimon</h5>
                            <a href="/usuario/decksOP" class="btn btn-primary">Ver Mazos</a>
                        </div>
                    </div>
                </div>
                <div class="col d-flex justify-content-center">
                    <div class="card text-center" style="width: 18rem;">
                        <img src="{{ asset('images/logo_pk.png') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Magic</h5>
                            <a href="/usuario/decks" class="btn btn-primary">Ver Mazos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>