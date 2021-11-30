<template>
    <nav>
        <div class="menu-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mobile">
                            <div class="row">
                                <div class="col-6">
                                    <div class="actual">Administrar</div>
                                </div>
                                <div class="col-6 text-right">
                                    <div class="toggle-menu"><i class="ri-menu-line"></i></div>
                                </div>
                            </div>
                        </div>
                        <ul id="menu-t">
                            <li id="e_guias">
                                <router-link to="/guides" class="nav-item nav-link">Guias</router-link>
                            </li>
                            <li id="e_invoices">
                               <router-link to="/invoices" class="nav-item nav-link">Facturas</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> 
        </div>
    </nav>

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