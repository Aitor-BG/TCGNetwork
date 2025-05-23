<x-app-layout>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>One Piece TCG</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>

    <body>
        <div class="container mt-5">
            <h1 class="text-center mb-4">One Piece TCG</h1>

            <!-- FILTROS -->
            <form method="GET" class="row mb-4">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Buscar por nombre"
                        value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">Tipo</option>
                        <option value="LEADER" {{ request('type') == 'LEADER' ? 'selected' : '' }}>Leader</option>
                        <option value="CHARACTER" {{ request('type') == 'CHARACTER' ? 'selected' : '' }}>Character
                        </option>
                        <option value="EVENT" {{ request('type') == 'EVENT' ? 'selected' : '' }}>Event</option>
                        <option value="STAGE" {{ request('type') == 'STAGE' ? 'selected' : '' }}>Stage</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="color" class="form-select">
                        <option value="">Color</option>
                        <option value="Red" {{ request('color') == 'Red' ? 'selected' : '' }}>Rojo</option>
                        <option value="Green" {{ request('color') == 'Green' ? 'selected' : '' }}>Verde</option>
                        <option value="Blue" {{ request('color') == 'Blue' ? 'selected' : '' }}>Azul</option>
                        <option value="Purple" {{ request('color') == 'Purple' ? 'selected' : '' }}>Morado</option>
                        <option value="Black" {{ request('color') == 'Black' ? 'selected' : '' }}>Negro</option>
                        <option value="Yellow" {{ request('color') == 'Yellow' ? 'selected' : '' }}>Amarillo</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>

            <div class="row justify-content-center">
                <div class="col-4">
                    <h5>Cartas Seleccionadas: <span id="totalCardsCount">0</span>/51</h5>
                    <!--<ul id="selectedCards" class="list-group"></ul>-->
                    <ul id="selectedCards" class="list-group" style="max-height: 500px; overflow-y: auto;"></ul>
                    <br>
                    <button class="btn btn-info" onclick="exportDeck()">Exportar deck</button>
                </div>
                <div class="col-8">
                    <div class="row">
                        @foreach ($datos['data'] as $dato)
                            <div class="col-md-2 mb-4">
                                <div class="container text-center">
                                    <img src="{{ $dato['images']['small'] }}" alt="{{ $dato['code'] }}"
                                        class="img-fluid rounded carta" data-bs-toggle="modal" data-bs-target="#imageModal"
                                        data-bs-image="{{ $dato['images']['small'] }}" loading="lazy">
                                    <div class="mt-2">
                                        <button class="btn btn-sm btn-danger"
                                            onclick="updateCounter(this, -1, '{{ $dato['code'] }}', '{{ $dato['images']['small'] }}')"
                                            data-card-name="{{ $dato['name'] . ' - ' . $dato['code'] }}">-</button>
                                        <span class="counter">0</span>
                                        <!--<button class="btn btn-sm btn-success"
                                                        onclick="updateCounter(this, 1, '{{ $dato['code'] }}', '{{ $dato['images']['small'] }}')"
                                                        data-card-name="{{ $dato['name'] . ' - ' . $dato['code'] }}">+</button>-->
                                        <button class="btn btn-sm btn-success"
                                            onclick="updateCounter(this, 1, '{{ $dato['code'] }}', '{{ $dato['images']['small'] }}', '{{ $dato['type'] }}')"
                                            data-card-name="{{ $dato['name'] . ' - ' . $dato['code'] }}">+</button>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- PAGINACIÓN -->
            <nav aria-label="Pagination" class="d-flex justify-content-center">
                <ul class="pagination">
                    @if ($page > 1)
                        <li class="page-item">
                            <a class="page-link"
                                href="?page={{ $page - 1 }}&{{ http_build_query(request()->except('page')) }}">Anterior</a>
                        </li>
                    @endif
                    @if (isset($datos['totalPages']) && $page < $datos['totalPages'])
                        <li class="page-item">
                            <a class="page-link"
                                href="?page={{ $page + 1 }}&{{ http_build_query(request()->except('page')) }}">Siguiente</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>

        <!-- MODAL -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="" id="modalImage" class="img-fluid" alt="Imagen Ampliada">
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- SCRIPTS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const savedCards = JSON.parse(localStorage.getItem("selectedCards")) || {};
                const selectedCards = document.getElementById("selectedCards");

                for (const [cardName, { count, image }] of Object.entries(savedCards)) {
                    if (count > 0) {
                        const listItem = document.createElement("li");
                        listItem.id = `card-${cardName}`;
                        listItem.classList.add("list-group-item", "d-flex", "align-items-center", "gap-2");

                        const img = document.createElement("img");
                        img.src = image;
                        img.alt = cardName;
                        img.width = 50;
                        img.height = 50;
                        img.classList.add("rounded");

                        const text = document.createElement("span");
                        text.textContent = `${cardName} x${count}`;

                        listItem.appendChild(img);
                        listItem.appendChild(text);
                        selectedCards.appendChild(listItem);
                    }
                }


                document.querySelectorAll(".container").forEach(container => {
                    const cardName = container.querySelector("button")?.getAttribute("data-card-name");
                    if (!cardName) return;
                    const counter = container.querySelector(".counter");
                    const count = savedCards[cardName]?.count || 0;
                    counter.innerText = count;
                });

                updateTotalCardCount();
            });

            /*function updateCounter(button, change, cardName, cardImage, cardType) {
                const counter = button.parentElement.querySelector(".counter");
                let count = parseInt(counter.innerText);
                count = Math.min(4, Math.max(0, count + change));
                counter.innerText = count;

                const selectedCards = document.getElementById("selectedCards");
                let savedCards = JSON.parse(localStorage.getItem("selectedCards")) || {};
                console.log(savedCards)

                if (count > 0) {
                    savedCards[cardName] = { count, image: cardImage };

                    let listItem = document.getElementById(`card-${cardName}`);
                    if (!listItem) {
                        listItem = document.createElement("li");
                        listItem.id = `card-${cardName}`;
                        listItem.classList.add("list-group-item", "d-flex", "align-items-center", "gap-2");

                        const img = document.createElement("img");
                        img.src = cardImage;
                        img.alt = cardName;
                        img.width = 50;
                        img.height = 50;
                        img.classList.add("rounded");

                        const text = document.createElement("span");
                        text.textContent = `${cardName} x${count}`;

                        listItem.appendChild(img);
                        listItem.appendChild(text);
                        selectedCards.appendChild(listItem);

                    } else {
                        
                        const textSpan = listItem.querySelector("span");
                        if (textSpan) {
                            textSpan.textContent = `${cardName} x${count}`;
                        }

                    }
                } else {
                    delete savedCards[cardName];
                    const listItem = document.getElementById(`card-${cardName}`);
                    if (listItem) selectedCards.removeChild(listItem);
                }

                console.log(JSON.stringify(savedCards))
                localStorage.setItem("selectedCards", JSON.stringify(savedCards));
                console.log(localStorage)
            }*/

            /*function updateCounter(button, change, cardName, cardImage, cardType) {
                const counter = button.parentElement.querySelector(".counter");
                let currentCount = parseInt(counter.innerText);
                let newCount = Math.min(4, Math.max(0, currentCount + change));

                const selectedCards = document.getElementById("selectedCards");
                let savedCards = JSON.parse(localStorage.getItem("selectedCards")) || {};

                // 🚫 Restricción para cartas tipo LEADER
                if (cardType === "LEADER" && change > 0) {
                    const existingLeader = Object.entries(savedCards).find(([_, value]) => value.type === "LEADER");

                    if (existingLeader && !savedCards[cardName]) {
                        alert("Solo puedes agregar un líder al mazo.");
                        return;
                    }

                    if (savedCards[cardName]?.count >= 1) {
                        alert("Solo puedes tener un líder.");
                        return;
                    }

                    newCount = 1; // fuerza máximo 1
                }

                // Actualiza contador en la carta
                counter.innerText = newCount;

                if (newCount > 0) {
                    savedCards[cardName] = { count: newCount, image: cardImage, type: cardType };

                    let listItem = document.getElementById(`card-${cardName}`);
                    if (!listItem) {
                        listItem = document.createElement("li");
                        listItem.id = `card-${cardName}`;
                        listItem.classList.add("list-group-item", "d-flex", "align-items-center", "gap-2");

                        const img = document.createElement("img");
                        img.src = cardImage;
                        img.alt = cardName;
                        img.width = 50;
                        img.height = 50;
                        img.classList.add("rounded");

                        const text = document.createElement("span");
                        text.textContent = `${cardName} x${newCount}`;

                        listItem.appendChild(img);
                        listItem.appendChild(text);
                        selectedCards.appendChild(listItem);
                    } else {
                        const textSpan = listItem.querySelector("span");
                        if (textSpan) {
                            textSpan.textContent = `${cardName} x${newCount}`;
                        }
                    }
                } else {
                    delete savedCards[cardName];
                    const listItem = document.getElementById(`card-${cardName}`);
                    if (listItem) selectedCards.removeChild(listItem);
                }

                localStorage.setItem("selectedCards", JSON.stringify(savedCards));
            }*/

            function updateCounter(button, change, cardName, cardImage, cardType) {
                const counter = button.parentElement.querySelector(".counter");
                let currentCount = parseInt(counter.innerText);
                let newCount = Math.min(4, Math.max(0, currentCount + change));

                let savedCards = JSON.parse(localStorage.getItem("selectedCards")) || {};

                // 🚫 Restricción para cartas tipo LEADER
                if (cardType === "LEADER" && change > 0) {
                    const existingLeader = Object.entries(savedCards).find(([_, value]) => value.type === "LEADER");

                    if (existingLeader && !savedCards[cardName]) {
                        alert("Solo puedes agregar un líder al mazo.");
                        return;
                    }

                    if (savedCards[cardName]?.count >= 1) {
                        alert("Solo puedes tener un líder.");
                        return;
                    }

                    newCount = 1;
                }

                // ✅ Limite total de cartas (51 máx.)
                const totalCards = Object.values(savedCards).reduce((sum, card) => sum + card.count, 0);
                const isNewCard = !savedCards[cardName];
                const currentCardCount = savedCards[cardName]?.count || 0;
                const totalAfterChange = totalCards - currentCardCount + newCount;

                if (totalAfterChange > 51) {
                    alert("No puedes añadir más de 51 cartas en total al mazo.");
                    return;
                }

                // Actualiza visualmente el contador
                counter.innerText = newCount;

                const selectedCards = document.getElementById("selectedCards");

                if (newCount > 0) {
                    savedCards[cardName] = { count: newCount, image: cardImage, type: cardType };

                    let listItem = document.getElementById(`card-${cardName}`);
                    if (!listItem) {
                        listItem = document.createElement("li");
                        listItem.id = `card-${cardName}`;
                        listItem.classList.add("list-group-item", "d-flex", "align-items-center", "gap-2");

                        const img = document.createElement("img");
                        img.src = cardImage;
                        img.alt = cardName;
                        img.width = 50;
                        img.height = 50;
                        img.classList.add("rounded");

                        const text = document.createElement("span");
                        text.textContent = `${cardName} x${newCount}`;

                        listItem.appendChild(img);
                        listItem.appendChild(text);
                        selectedCards.appendChild(listItem);
                    } else {
                        const textSpan = listItem.querySelector("span");
                        if (textSpan) {
                            textSpan.textContent = `${cardName} x${newCount}`;
                        }
                    }
                } else {
                    delete savedCards[cardName];
                    const listItem = document.getElementById(`card-${cardName}`);
                    if (listItem) selectedCards.removeChild(listItem);
                }

                localStorage.setItem("selectedCards", JSON.stringify(savedCards));
                updateTotalCardCount();
            }

function updateTotalCardCount() {
    const savedCards = JSON.parse(localStorage.getItem("selectedCards")) || {};
    const totalCards = Object.values(savedCards).reduce((sum, card) => sum + card.count, 0);
    document.getElementById("totalCardsCount").innerText = totalCards;
}


            function exportDeck() {
                const savedCards = JSON.parse(localStorage.getItem("selectedCards")) || {};
                if (Object.keys(savedCards).length === 0) {
                    alert("No hay cartas seleccionadas.");
                    return;
                }

                const deckContent = Object.entries(savedCards)
                    .map(([cardName, { count }]) => `${count}x${cardName}`)
                    .join("\n");

                const blob = new Blob([deckContent], { type: "text/plain" });
                const url = URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.href = url;
                a.download = "mi_deck.txt";
                a.click();
                URL.revokeObjectURL(url);
            }

            var imageModal = document.getElementById("imageModal");
            imageModal.addEventListener("show.bs.modal", function (event) {
                const img = event.relatedTarget;
                const modalImage = document.getElementById("modalImage");
                modalImage.src = img.getAttribute("data-bs-image");
            });

            let unloadTimer;

            // 1. Detectar recarga
            window.addEventListener("beforeunload", () => {
                sessionStorage.setItem("isReload", "true");
            });

            // 2. Detectar salida real
            document.addEventListener("visibilitychange", () => {
                if (document.visibilityState === "hidden") {
                    unloadTimer = setTimeout(() => {
                        const isReload = sessionStorage.getItem("isReload");

                        if (!isReload) {
                            // No fue recarga: eliminar cartas
                            localStorage.removeItem("selectedCards");
                            console.log("Cartas borradas por salida real del sitio.");
                        } else {
                            console.log("Recarga detectada, no se borran las cartas.");
                        }
                    }, 1000);
                } else if (document.visibilityState === "visible") {
                    clearTimeout(unloadTimer);
                    // 3. Limpiar bandera al volver
                    sessionStorage.removeItem("isReload");
                }
            });

            // 4. También al cargar la página, limpia la bandera por si quedó
            window.addEventListener("load", () => {
                sessionStorage.removeItem("isReload");
            });


        </script>
    </body>

    </html>
</x-app-layout>