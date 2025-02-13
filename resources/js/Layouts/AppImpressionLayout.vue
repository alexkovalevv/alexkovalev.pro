<script setup>
import {ref} from 'vue'
import Header from "@/Components/Impression/Header.vue";
import HeroBlock from "@/Components/Impression/HeroBlock.vue";
</script>

<template>
    <Header/>
    <main>
        <HeroBlock/>
        <slot/>
    </main>
</template>

