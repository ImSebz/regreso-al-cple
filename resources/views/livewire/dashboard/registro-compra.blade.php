<div class="main-registro-compra-container">
    <div class="registro-compra-container">
        <div class="main-info-cont">
            <h1>Regístrate y sé 1 de los 1200 ganadores</h1>
            {{-- Logo Bonos --}}
            <div class="info-text-cont">
                {{-- <p>1. Registra tu factura por compra igual o superior a $30.000 en productos de nuestras marcas Paper Mate®, Sharpie®, Prismacolor®.</p> --}}
                <p>1. Sube tu factura* debe incluir 1 caja de colores Paper Mate® y/o Prismacolor®.</p> 
                {{-- Caja colores foto --}}
                <p>2. Sube la foto de tu dibujo* hecho a mano.</p>
                {{-- Look&Feel --}}

            </div>
        </div>
        <div class="main-fotos-cont">
            <div class="fotos-cont">
                <div class="foto-factura-cont">
                    <label for="foto_factura" class="fotos-label">Sube tu factura</label>
                    <input type="file" id="foto_factura" accept="image/*" capture="user" style="display: none;">
                    <div class="foto-factura-background">
                        <label for="foto_factura" class="custom-file-upload" id="imagePreviewFactura"
                        style="{{ $foto_factura ? 'background-image: url(' . $foto_factura->temporaryUrl() . '); background-size: 75%;' : '' }}">
                    </label>
                    </div>
                    
                    @error('foto_factura')
                        <div class="text-invalid-factura">
                            {{ $message }}
                        </div>
                    @enderror
                    <div wire:loading wire:target="foto_factura">
                        Cargando...
                    </div>
                </div>
    
                <div class="foto-portada-cont">
                    <label for="foto_portada" class="fotos-label">Sube tu dibujo</label>
                    <input type="file" id="foto_portada" accept="image/*" capture="user" style="display: none;">
                    <div class="foto-portada-background">
                        <label for="foto_portada" class="custom-file-upload" id="imagePreviewPortada"
                        style="{{ $foto_portada ? 'background-image: url(' . $foto_portada->temporaryUrl() . '); background-size: 75%;' : '' }}">
                    </label>
                    </div>
                    @error('foto_portada')
                        <div class="text-invalid-portada">
                            {{ $message }}
                        </div>
                    @enderror
                    <div wire:loading wire:target="foto_portada">
                        Cargando...
                    </div>
                </div>
            </div>
            <div class="registrar-compra-btn">
                <button wire:click="storeCompra" id="registrar_compra">Enviar</button>
            </div>
        </div>

        @script
            @if (session('register-success'))
                <script>
                    Swal.fire({
                        title: '{{ session('title') }}',
                        text: '{{ session('register-success') }}',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                </script>
            @endif

            <script>
                const MAX_WIDTH = 1020;
                const MAX_HEIGHT = 980;
                const MIME_TYPE = "image/jpeg";
                const QUALITY = 0.9;

                const foto_factura = document.getElementById("foto_factura");
                const foto_portada = document.getElementById("foto_portada");

                foto_factura.onchange = (ev) => {
                    const file = ev.target.files[0];
                    const blobURL = URL.createObjectURL(file);
                    const img = new Image();
                    img.src = blobURL;
                    img.onerror = () => {
                        URL.revokeObjectURL(this.src);
                        // Handle the failure properly
                        console.err("Cannot load image");
                    };
                    img.onload = () => {
                        URL.revokeObjectURL(this.src);
                        const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
                        const canvas = document.createElement("canvas");
                        canvas.width = newWidth;
                        canvas.height = newHeight;
                        const ctx = canvas.getContext("2d");
                        ctx.drawImage(img, 0, 0, newWidth, newHeight);
                        canvas.toBlob(
                            blob => {
                                upload_foto_factura(blob);
                            },
                            MIME_TYPE,
                            QUALITY);
                    };
                };

                foto_portada.onchange = (ev) => {
                    const file = ev.target.files[0];
                    const blobURL = URL.createObjectURL(file);
                    const img = new Image();
                    img.src = blobURL;
                    img.onerror = () => {
                        URL.revokeObjectURL(this.src);
                        // Handle the failure properly
                        console.err("Cannot load image");
                    };
                    img.onload = () => {
                        URL.revokeObjectURL(this.src);
                        const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
                        const canvas = document.createElement("canvas");
                        canvas.width = newWidth;
                        canvas.height = newHeight;
                        const ctx = canvas.getContext("2d");
                        ctx.drawImage(img, 0, 0, newWidth, newHeight);
                        canvas.toBlob(
                            blob => {
                                upload_foto_portada(blob);
                            },
                            MIME_TYPE,
                            QUALITY);
                    };
                };

                const calculateSize = (img, maxWidth, maxHeight) => {
                    let width = img.width;
                    let height = img.height;

                    // calculate the width and height, constraining the proportions
                    if (width > height) {
                        if (width > maxWidth) {
                            height = Math.round(height * maxWidth / width);
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width = Math.round(width * maxHeight / height);
                            height = maxHeight;
                        }
                    }

                    return [width, height];
                }

                const upload_foto_factura = (file) => {
                    $wire.upload('foto_factura', file, (uploadedFilename) => {});
                }

                const upload_foto_portada = (file) => {
                    $wire.upload('foto_portada', file, (uploadedFilename) => {});
                }
            </script>
        @endscript
    </div>
</div>
