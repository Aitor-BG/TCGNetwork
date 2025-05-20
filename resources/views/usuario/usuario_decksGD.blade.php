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
            <h1 class="text-center mb-4">Gundam</h1>

            <!-- FILTROS -->
            <form method="GET" class="row mb-4">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Buscar por nombre"
                        value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>

            <div class="row justify-content-center">
                <div class="col-4">
                    <h5>Cartas Seleccionadas:</h5>
                    <ul id="selectedCards" class="list-group"></ul>
                    <button class="btn btn-info" onclick="exportDeck()">Exportar deck</button>
                </div>
                <div class="col-8">
                    <div class="row">
                        @foreach ($datos['data'] as $dato)
                            <div class="col-md-2 mb-4">
                                <div class="container text-center">
                                    <img src="{{ $dato['images']['small'] }}" alt="{{ $dato['id'] }}"
                                        class="img-fluid rounded carta" data-bs-toggle="modal" data-bs-target="#imageModal"
                                        data-bs-image="{{ $dato['images']['small'] }}" loading="lazy">
                                    <div class="mt-2">
                                        <button class="btn btn-sm btn-danger"
                                            onclick="updateCounter(this, -1, '{{ $dato['name'] . ' - ' . $dato['id'] }}', '{{ $dato['images']['small'] }}')"
                                            data-card-name="{{ $dato['name'] . ' - ' . $dato['id'] }}">-</button>
                                        <span class="counter">0</span>
                                        <button class="btn btn-sm btn-success"
                                            onclick="updateCounter(this, 1, '{{ $dato['name'] . ' - ' . $dato['id'] }}', '{{ $dato['images']['small'] }}')"
                                            data-card-name="{{ $dato['name'] . ' - ' . $dato['id'] }}">+</button>
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
                        listItem.classList.add("list-group-item");

                        const img = document.createElement("img");
                        img.src = image;
                        img.alt = cardName;
                        img.classList.add("img-fluid", "rounded");
                        listItem.appendChild(img);
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
            });

            function updateCounter(button, change, cardName, cardImage) {
                const counter = button.parentElement.querySelector(".counter");
                let count = parseInt(counter.innerText);
                count = Math.min(4, Math.max(0, count + change));
                counter.innerText = count;

                const selectedCards = document.getElementById("selectedCards");
                let savedCards = JSON.parse(localStorage.getItem("selectedCards")) || {};

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

                        /*listItem.classList.add("list-group-item");

                        const img = document.createElement("img");
                        img.src = cardImage;
                        img.alt = cardName;
                        img.width = 80;
                        img.height = 80;
                        img.classList.add("img-fluid", "rounded");

                        const text = document.createTextNode(`${cardName} x${count}`);
                        listItem.appendChild(img);
                        listItem.appendChild(text);
                        selectedCards.appendChild(listItem);*/
                    } else {
                        listItem.childNodes[1].nodeValue = `${cardName} x${count}`;
                    }
                } else {
                    delete savedCards[cardName];
                    const listItem = document.getElementById(`card-${cardName}`);
                    if (listItem) selectedCards.removeChild(listItem);
                }

                localStorage.setItem("selectedCards", JSON.stringify(savedCards));
            }

            function exportDeck() {
                const savedCards = JSON.parse(localStorage.getItem("selectedCards")) || {};
                if (Object.keys(savedCards).length === 0) {
                    alert("No hay cartas seleccionadas.");
                    return;
                }

                const deckContent = Object.entries(savedCards)
                    .map(([cardName, { count }]) => `${cardName} x${count}`)
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
        </script>
    </body>

    </html>
</x-app-layout>