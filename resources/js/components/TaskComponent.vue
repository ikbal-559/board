<template>
    <div class="card shadow" @click="$emit('show-card-details', card)">
        <h5>{{ card.title }}</h5>
        <span class="text-sm">{{ card.created }}</span>
    </div>
</template>
<script>
    export default {
        props: {
            card: {
                type: Object,
                default: () => ({})
            }
        }
    };
</script>
