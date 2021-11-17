<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <a href="#"><img src="http://www.experteam.com.ec/logoweb.png"></a><br>
            <br>
            <span class="text-secondary">Prueba técnica desarrollada por José Tovar</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <!-- for logged-in user-->
                <div class="navbar-nav">
                    <!-- <router-link to="/dashboard" class="nav-item nav-link">Dashboard</router-link> -->
                    <router-link to="/guides" class="nav-item nav-link">Guias</router-link>
                    <router-link to="/invoices" class="nav-item nav-link">Facturas</router-link>
                </div>
            </div>
        </nav>
    </div>

    <br/>
    <router-view></router-view>
</template>

<script>
export default {
    name: "App",
    data() {
        return {
            
        }
    },
    created() {
        
    },
    methods: {
        
    },
}
</script>