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

        <div class="container my-5">
            <div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">

                <div class="col d-flex justify-content-center">
                    <div class="card text-center shadow" style="width: 18rem;">
                        <img src="{{ asset('images/logo_op.png') }}" class="card-img-top" alt="One Piece Logo">
                        <div class="card-body">
                            <h5 class="card-title">One Piece Card Game</h5>
                            <a href="/usuario/decksOP" class="btn btn-primary">Crear Mazo</a>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card text-center shadow" style="width: 18rem;">
                        <img src="{{ asset('images/logo_db.png') }}" class="card-img-top" alt="Dragon Ball Logo">
                        <div class="card-body">
                            <h5 class="card-title">Dragon Ball: Fusion World</h5>
                            <a href="/usuario/decksDB" class="btn btn-primary">Crear Mazo</a>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card text-center shadow" style="width: 18rem;">
                        <img src="{{ asset('images/logo_dg.png') }}" class="card-img-top" alt="Digimon Logo">
                        <div class="card-body">
                            <h5 class="card-title">Digimon Card Game</h5>
                            <a href="/usuario/decksDG" class="btn btn-primary">Crear Mazo</a>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card text-center shadow" style="width: 18rem;">
                        <img src="{{ asset('images/logo_GD.png') }}" class="card-img-top" alt="Gundam Logo">
                        <div class="card-body">
                            <h5 class="card-title">Gundam Card Game</h5>
                            <a href="/usuario/decksGD" class="btn btn-primary">Crear Mazo</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script>
            window.addEventListener("DOMContentLoaded", () => {
                localStorage.removeItem("selectedCards");
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
</x-app-layout>