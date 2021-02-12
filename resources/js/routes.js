
let routes=[
    {path:'/dashboard',component:require('./components/ExampleComponent.vue').default},
    {path:'/users',component:require('./components/users.vue').default},
    {path:'/profile',component:require('./components/Profile.vue').default},
    {path: '/developer',component:require('./components/developers.vue').default},
    {path: '/categories',component:require('./components/Categories.vue').default},
    {path: '/subcategories',component:require('./components/Sub-categories.vue').default},
    {path: '/items',component:require('./components/items.vue').default},
    {path: '/resources',component:require('./components/resourses.vue').default},
    {path: '/purches',component:require('./components/Purches.vue').default},
    {path: '/casher',component:require('./components/Casher.vue').default},
    {path: '/reports',component:require('./components/Reports.vue').default},
    {path: '/reportspurches',component:require('./components/ReportPurches').default},
    {path: '/reportsbuyers',component:require('./components/ReportBuyers').default},
    {path: '/reporting',component:require('./components/Reportings').default},

    




];


export default routes;
