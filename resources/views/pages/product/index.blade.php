<x-user.layout>
    <section class="bg-white min-h-screen p-2 m-2 flex gap-4">
        <div class="w-[80%] flex flex-col">
            <div class="flex gap-4 pb-10">
                <div class="w-[30%]">
                    <img id="mainThumbnail" class="w-full h-80 object-cover border border-blue-500 mb-2 rounded-md"
                         src="{{ asset('images/galleries/'.$single_product->thumbnail) }}" alt="Product">
                    <div class="flex w-full">
                        @foreach ($single_product_gallery as $item)
                            <div class="w-[20%]">
                                <a href="javascript:void(0);" onclick="changeThumbnail('{{ asset('images/galleries/'.$item->image_name) }}')">
                                    <img class="w-full h-20 object-cover border white-blue-500 mb-5 rounded-md"
                                         src="{{ asset('images/galleries/'.$item->image_name) }}" alt="Product">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                
                
                <div class="w-[50%] flex flex-col gap-4">
                    <h3 class="text-xl">{{ $single_product->description }}</h3>
                    <p id="discountPrice" class="text-3xl text-orange-500">&#2547; {{ $discount_price }}</p>
                    <div class="flex items-center gap-2 text-14">
                        <p class="text-gray-500 line-through">&#2547; {{ $single_product->price }}</p>
                        <p>-{{ $single_product->discount }}%</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <p class="text-14 text-gray-500">Quantity</p>
                        <div class="flex items-center gap-4">
                            <button onclick="decreaseQuantity()"
                                class="bg-gray-200 text-gray-500 hover:bg-gray-500 hover:text-gray-200 p-2 rounded transition-all duration-500">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M432 256c0 17.7-14.3 32-32 32L48 288c-17.7 0-32-14.3-32-32s14.3-32 32-32l352 0c17.7 0 32 14.3 32 32z" />
                                </svg>
                            </button>
                            <span id="quantity">1</span>
                            <button onclick="increaseQuantity()"
                                class="bg-gray-200 text-gray-500 hover:bg-gray-500 hover:text-gray-200 p-2 rounded transition-all duration-500">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <a href="#"
                            class="bg-sky-400 hover:bg-sky-500 text-white font-bold py-2 px-4 rounded transition-all duration-500 shadow-md hover:shadow-lg hover:shadow-sky-400">
                            Buy Now
                        </a>
                        <a href="#"
                            class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded transition-all duration-500 hover:shadow-lg hover:shadow-orange-500">
                            Add to Cart
                        </a>
                    </div>
                </div>
                
                
                
            </div>
            <div class="flex gap-12">
                <div>
                    <p class="text-18 font-bold text-gray-500 pb-2">Delivery</p>
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between gap-8">
                            <div class="max-w-56">
                                <p class="flex gap-4 text-justify text-14 text-gray-500">
                                    <span>
                                        <svg class="fill-current h-5 w-5 mt-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 384 512">
                                            <path
                                                d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                                        </svg>
                                    </span>
                                    <span>Dhaka, Dhaka North, Banani Road No. 12 - 19</span>
                                </p>
                            </div>
                            <div>
                                <button class="text-blue-500 text-14">Change</button>
                            </div>
                        </div>
                        <p class="flex gap-4 max-w-56 text-justify text-14 text-gray-500">
                            <span>
                                <svg class="fill-current h-5 w-5 mt-1" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512">
                                    <path
                                        d="M352 256c0 22.2-1.2 43.6-3.3 64H163.3c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64H348.7c2.2 20.4 3.3 41.8 3.3 64zm28.8-64H503.9c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64H380.8c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64zm112.6-32H376.7c-10-63.9-29.8-117.4-55.3-151.6c78.3 20.7 142 77.5 171.9 151.6zm-149.1 0H167.7c6.1-36.4 15.5-68.6 27-94.7c10.5-23.6 22.2-40.7 33.5-51.5C239.4 3.2 248.7 0 256 0s16.6 3.2 27.8 13.8c11.3 10.8 23 27.9 33.5 51.5c11.6 26 20.9 58.2 27 94.7zm-209 0H18.6C48.6 85.9 112.2 29.1 190.6 8.4C165.1 42.6 145.3 96.1 135.3 160zM8.1 192H131.2c-2.1 20.6-3.2 42-3.2 64s1.1 43.4 3.2 64H8.1C2.8 299.5 0 278.1 0 256s2.8-43.5 8.1-64zM194.7 446.6c-11.6-26-20.9-58.2-27-94.6H344.3c-6.1 36.4-15.5 68.6-27 94.6c-10.5 23.6-22.2 40.7-33.5 51.5C272.6 508.8 263.3 512 256 512s-16.6-3.2-27.8-13.8c-11.3-10.8-23-27.9-33.5-51.5zM135.3 352c10 63.9 29.8 117.4 55.3 151.6C112.2 482.9 48.6 426.1 18.6 352H135.3zm358.1 0c-30 74.1-93.6 130.9-171.9 151.6c25.5-34.2 45.2-87.7 55.3-151.6H493.4z" />
                                </svg>
                            </span>
                            <span>
                                Ships from Overseas
                            </span>
                        </p>
                        <div class="flex justify-between">
                            <div class="max-w-56">
                                <p class="flex gap-4 text-justify text-14 text-gray-500">
                                    <span>
                                        <svg class="fill-current h-5 w-5 mt-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 576 512">
                                            <path
                                                d="M0 32C0 14.3 14.3 0 32 0h72.9c27.5 0 52 17.6 60.7 43.8L257.7 320c30.1 .5 56.8 14.9 74 37l202.1-67.4c16.8-5.6 34.9 3.5 40.5 20.2s-3.5 34.9-20.2 40.5L352 417.7c-.9 52.2-43.5 94.3-96 94.3c-53 0-96-43-96-96c0-30.8 14.5-58.2 37-75.8L104.9 64H32C14.3 64 0 49.7 0 32zM244.8 134.5c-5.5-16.8 3.7-34.9 20.5-40.3L311 79.4l19.8 60.9 60.9-19.8L371.8 59.6l45.7-14.8c16.8-5.5 34.9 3.7 40.3 20.5l49.4 152.2c5.5 16.8-3.7 34.9-20.5 40.3L334.5 307.2c-16.8 5.5-34.9-3.7-40.3-20.5L244.8 134.5z" />
                                        </svg>
                                    </span>
                                    <span>Standard Delivery 3 May - 10 May 23 - 30 day(s)</span>
                                </p>
                            </div>
                            <p class="text-14 text-gray-500 flex">&#2547; 50</p>
                        </div>
                        <p class="flex gap-4 max-w-56 text-justify text-14 text-gray-500">
                            <span>
                                <svg class="fill-current h-5 w-5 mt-1" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 384 512">
                                    <path
                                        d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM64 80c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm128 72c8.8 0 16 7.2 16 16v17.3c8.5 1.2 16.7 3.1 24.1 5.1c8.5 2.3 13.6 11 11.3 19.6s-11 13.6-19.6 11.3c-11.1-3-22-5.2-32.1-5.3c-8.4-.1-17.4 1.8-23.6 5.5c-5.7 3.4-8.1 7.3-8.1 12.8c0 3.7 1.3 6.5 7.3 10.1c6.9 4.1 16.6 7.1 29.2 10.9l.5 .1 0 0 0 0c11.3 3.4 25.3 7.6 36.3 14.6c12.1 7.6 22.4 19.7 22.7 38.2c.3 19.3-9.6 33.3-22.9 41.6c-7.7 4.8-16.4 7.6-25.1 9.1V440c0 8.8-7.2 16-16 16s-16-7.2-16-16V422.2c-11.2-2.1-21.7-5.7-30.9-8.9l0 0 0 0c-2.1-.7-4.2-1.4-6.2-2.1c-8.4-2.8-12.9-11.9-10.1-20.2s11.9-12.9 20.2-10.1c2.5 .8 4.8 1.6 7.1 2.4l0 0 0 0 0 0c13.6 4.6 24.6 8.4 36.3 8.7c9.1 .3 17.9-1.7 23.7-5.3c5.1-3.2 7.9-7.3 7.8-14c-.1-4.6-1.8-7.8-7.7-11.6c-6.8-4.3-16.5-7.4-29-11.2l-1.6-.5 0 0c-11-3.3-24.3-7.3-34.8-13.7c-12-7.2-22.6-18.9-22.7-37.3c-.1-19.4 10.8-32.8 23.8-40.5c7.5-4.4 15.8-7.2 24.1-8.7V232c0-8.8 7.2-16 16-16z" />
                                </svg>
                            </span>
                            <span>
                                Cash on Delivery Available
                            </span>
                        </p>
                    </div>
                </div>
                <div>
                    <p class="text-18 font-bold text-gray-500 pb-2">Service</p>
                    <div class="flex flex-col gap-4">
                        <p class="flex gap-4 max-w-56 text-justify text-14 text-gray-500">
                            <span>
                                <svg class="fill-current w-5 h-5 mt-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M7.8 207.7c-13.1-17.8-9.3-42.8 8.5-55.9L142.9 58.5C166.2 41.3 194.5 32 223.5 32H384 544c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H507.2l-44.9 36c-22.7 18.2-50.9 28-80 28H304 288 224c-17.7 0-32-14.3-32-32s14.3-32 32-32h64 16c8.8 0 16-7.2 16-16s-7.2-16-16-16H183.4L63.7 216.2c-17.8 13.1-42.8 9.3-55.9-8.5zM382.4 160l0 0 .9 0c-.3 0-.6 0-.9 0zM568.2 304.3c13.1 17.8 9.3 42.8-8.5 55.9L433.1 453.5c-23.4 17.2-51.6 26.5-80.7 26.5H192 32c-17.7 0-32-14.3-32-32V384c0-17.7 14.3-32 32-32H68.8l44.9-36c22.7-18.2 50.9-28 80-28H272h16 64c17.7 0 32 14.3 32 32s-14.3 32-32 32H288 272c-8.8 0-16 7.2-16 16s7.2 16 16 16H392.6l119.7-88.2c17.8-13.1 42.8-9.3 55.9 8.5zM193.6 352l0 0-.9 0c.3 0 .6 0 .9 0z"/></svg>
                            </span>
                            <span>
                                14 days free & easy return.Change of mind is not applicable
                            </span>
                        </p>
                        <p class="flex gap-4 max-w-56 text-justify text-14 text-gray-500">
                            <span>
                                <svg class="fill-current h-5 w-5 mt-1" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512">
                                    <path
                                        d="M256 0c4.6 0 9.2 1 13.4 2.9L457.7 82.8c22 9.3 38.4 31 38.3 57.2c-.5 99.2-41.3 280.7-213.6 363.2c-16.7 8-36.1 8-52.8 0C57.3 420.7 16.5 239.2 16 140c-.1-26.2 16.3-47.9 38.3-57.2L242.7 2.9C246.8 1 251.4 0 256 0zm0 66.8V444.8C394 378 431.1 230.1 432 141.4L256 66.8l0 0z" />
                                </svg>
                            </span>
                            <span>
                                Warranty not available
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-[20%]">
            <h3 class="text-22 font-semibold text-gray-500 mb-2">
                Related More
            </h3>
            <div class="flex flex-col gap-4">
                <a href="" class="relative bg-white hover:drop-shadow-lg  transition-all duration-500 rounded-lg">
    
                    <div class="relative">
                        <div class="block">
                            <img class="w-full h-40 object-cover rounded-t-lg" src="" alt="product name">
                        </div>
                    </div>
                    <div class="px-2 py-2">
                        <div class="text-14 font-semibold text-slate-700">
                            <div class="hover:text-slate-900">
                               hgfhgf
                
                            </div>
                        </div>
                        <div class="text-14 font-semibold text-slate-700">
                            <span>
                                231
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        </div>
    </section>
</x-user.layout>

<script>
    function changeThumbnail(newSrc) {
        document.getElementById('mainThumbnail').src = newSrc;
    }
</script>
<script>
    const discountPriceElement = document.getElementById('discountPrice');
    const quantityElement = document.getElementById('quantity');
    const baseDiscountPrice = {{ $discount_price }};
    const maxQuantity = 9;
    const minQuantity = 1;

    function updatePrice(quantity) {
        const newPrice = baseDiscountPrice * quantity;
        discountPriceElement.innerHTML = `&#2547; ${newPrice}`;
    }

    function increaseQuantity() {
        let quantity = parseInt(quantityElement.textContent);
        if (quantity < maxQuantity) {
            quantity++;
            quantityElement.textContent = quantity;
            updatePrice(quantity);
        }
    }

    function decreaseQuantity() {
        let quantity = parseInt(quantityElement.textContent);
        if (quantity > minQuantity) {
            quantity--;
            quantityElement.textContent = quantity;
            updatePrice(quantity);
        }
    }
</script>