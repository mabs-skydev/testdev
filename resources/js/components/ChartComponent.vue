<template>
    <div class="row mt-5">
        <h3 class="title">{{title}}</h3>
        <line-chart :data="datasets"></line-chart>
    </div>
</template>
<script>
export default {
    props: [
        'title', 'url'
    ],
    data() {
        return {
            datasets: []
        }
    },
    created() {
        axios.get(this.url)
            .then((response) => {
                this.datasets = response.data.datasets;
            })
    },
}
</script>
