<template>
    <table id="table_id" style="direction: rtl;margin: 0 auto;" class="table is-boordered data-table">
    <thead>
        <tr>
        <th>
            <th v-for="column in columns " :key="column.name" @click="$emit('sort',column.name)"
            :class="sortKey == column.name ? (sortOrder[column.name] > 0 ? 'sorting_asc' :'sorting_desc'): 'sorting' " 
            :style="'cursor:pointer;'">
            {{column.label}}</th>
    </tr>
    </thead>

</table> 
</template>

<script>
export default {
    props:['columns','sortKey','sortOrder']
}
</script>

<style scoped>

</style>