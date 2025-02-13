<script setup>

</script>

<template>
    <div class="hero">
        <!-- Контент -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative text-center px-4">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Большой заголовок</h1>
            <p class="text-lg md:text-xl mb-6">
                Краткое описание блока, которое помогает понять суть контента.
            </p>
            <div class="flex justify-center gap-4">
                <button
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium transition"
                >
                    Первая кнопка
                </button>
                <button
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium transition"
                >
                    Вторая кнопка
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.hero {
    background-color: black;
    background-image: url('@img/IMG_3187.png');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: right center;
    position: relative;
    min-height: 800px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;

}

.hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: inherit;
    background-size: inherit;
    background-position: inherit;
    backdrop-filter: blur(20px); /* Применяем эффект размытия */
    z-index: -1; /* Размытие остается на фоне */
    mask: radial-gradient(circle, rgba(0, 0, 0, 0) 70%, black 100%);
    -webkit-mask: radial-gradient(circle, rgba(0, 0, 0, 0) 70%, black 100%);
}

</style>
