<template>
    <div>
        <navigation></navigation>
        <slot></slot>
    </div>
</template>

<script>
    import Navigation from './Navigation';

    export default {
        components: {Navigation}
    }
</script>