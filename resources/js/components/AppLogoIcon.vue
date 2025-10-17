<script setup lang="ts">
import type { HTMLAttributes } from 'vue'

defineOptions({
    inheritAttrs: false,
})

interface Props {
    className?: HTMLAttributes['class']
}

defineProps<Props>()
</script>

<template>
    <img
        src="/dost-logo.png"
        alt="DOST Logo"
        :class="className"
        v-bind="$attrs"
    />
</template>
