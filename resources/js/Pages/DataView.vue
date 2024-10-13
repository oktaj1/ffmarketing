

<template>
    <div>
        <h1>{{ data.title }}</h1>
        <p>{{ data.description }}</p>
    </div>
</template>

<script>
export default {
    props: {
        data: Object,
    },
}
</script>
