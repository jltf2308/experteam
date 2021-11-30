<template>
    <div class="content sm">			
        <div class="container ">				
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-15">{{ titulo }}</h1>
                </div>
                <div class="col-lg-10 col-xl-8">
                    <p class="mb-30">{{ description }}</p>
                </div>
                <div class="col-12">
                    <div class="caja sm mb-15 especial">
                        <h2 class="inline-b mr-15">{{ add }}</h2> <a href="#" class="button-circle main link " @click.prevent="modalAdd()"><i class="ri-add-line"></i></a> 
                    </div>
                    
                    <div class="row mt-60 mb-30">
                        <div class="col-12 col-sm-6 col-md-8 col-lg-6">
                            <h2>{{ tableTitle }}</h2>
                            <p>{{ tableDescription }}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-30">
                        <div class="col-12">
                            <div class="tags-view" id="buttons">
                                <div class="tags">
                                   <button class="button-icon mr-15" @click.prevent="showFilter()"><i class="ri-filter-3-line"></i> Filtrar</button>
									<template v-for="(field, title) in filter" :key="title" id="botones">
										<button class="button-icon right mr-15" v-if="field.value && mostrarFiltro">
												{{field.title}}: {{field.value}}
											<i class="ri-close-line" @click.prevent="removeFilter(title)"></i>
										</button>
									</template>
                                </div>
                                <div class="displays">
									<div class="display" :class="cardShow?'active':''" id="mosaic" @click.prevent="switchViewTable()"> <i class="ri-layout-grid-fill"></i> </div>
									<div class="display" :class="listShow?'active':''" id="bars" @click.prevent="switchViewTable()"> <i class="ri-menu-line"></i> </div>
								</div>
                            </div>
                            <div class="col-12 mb-15 mt-30">
                                <div class="alert alert-success alert-dismissible inline-b" role="alert" id="alert">
                                    {{title_message}}
                                    <a href="#"  @click.prevent="stopTime()" class="inherit underline">Tienes {{IDLE_TIMEOUT - idleSecondsCounter}}s para deshacer esta acción.</a>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="alert alert-success alert-dismissible inline-b" role="alert" id="alertCreate">
                                    {{title_message_create}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" v-if="contadorArreglo == 0">
						<div class="col-6 col-md-4 col-lg-3 ">
							<div class="caja xs empty">
								<h4 class="mb-0">{{ nonRegister }}</h4>
							</div>
						</div>
					</div>

                    <div class="row mb-30" v-if="cardShow">
                        <div v-for="data in listCard" :key="data.id" class="col-12 col-sm-6 col-md-4 col-lg-3 mb-30">
                            <div class="caja xs" :class="{'gris':data.status=== 0, 'verde':data.id=== cardGreen}">
                                <h4 class="text-and-circle-button">{{ data.title }}</h4>
                                <button class="button-circle hover red align-top float-right" @click="openModalDestroy(data.id)"><i class="ri-delete-bin-line"></i></button>
                                <template v-for="(body, index) in data.body" :key="index">
                                    <div class="small">{{index}}</div>
                                    <p>{{body}}</p>
                                </template>
                                <div class="text-right">
                                    <button class="button-circle main mr-7" @click="openModalEdit(data.id)"><i class="ri-pencil-fill"></i></button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-30" v-if="listShow">
                        <div v-for="data in listTable" :key="data.id" class="col-12 mb-15">
                            <div class="caja sm lista">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td v-for="(value, name) in data.body" :key="name">
                                                <div class="small">{{name}}</div>
                                                <p>{{value}}</p>
                                            </td>
                                            <td class="text-right">
                                                <button class="button-circle hover mr-7"  @click="openModalEdit(data.id)"><i class="ri-pencil-fill"></i></button>
                                                <button class="button-circle red align-top mb-0" @click="openModalDestroy(data.id)"><i class="ri-delete-bin-line"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row"  v-if="contadorArreglo>0">
                    <div class="col">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item mr-2" v-if="pagination.current_page > 1" >
                                    <a href="#" class="button-pagination page-link" @click.prevent="changePage(pagination.current_page - 1)">
                                        <span>Anterior</span>
                                    </a>
                                </li>
                                <li class="page-item mr-2" v-if="pagination.current_page == 1" >
                                    <a class="button-pagination page-link disabled">
                                        <span>Anterior</span>
                                    </a>
                                </li>
                                <li class="page-item mr-2" v-for="page in pagesNumber" :key="page">
                                    <a href="#" :class="[page == isActive ? 'active' : '']" class="button-pagination page-link" @click.prevent="changePage(page)">
                                    {{page}}
                                    </a>
                                </li>
                                <li class="page-item mr-2" v-if="pagination.current_page < pagination.last_page">
                                    <a href="#" class="button-pagination page-link" @click.prevent="changePage(pagination.current_page + 1)">
                                        <span>Siguiente</span>
                                    </a>
                                </li>
                                <li class="page-item mr-2" v-if="pagination.current_page == pagination.last_page" >
                                    <a class="button-pagination page-link disabled">
                                        <span>Siguiente</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
export default {
    name:'generalView',
    emits: ['modalAdd', 'showModalFilter', 'clearFilter', 'removeOptionsFilter', 'getList', 'modalDelete', 'modalEdit'],
    props:{
        titulo:{
            type:String,
            required:true,
        },
        description:{
            type:String,
            required:true,
        },
        add:{
            type:String,
            required:true,
        },
        nonRegister:{
            type:String,
            required:true,
        },
        tableTitle:{
            type:String,
            required:true,
        },
        tableDescription:{
            type:String,
            required:true,
        },
        contadorArreglo:{
            type:Number,
            required:true,
        },
        filter:{
            type:Object,
            required:true
        },
        mostrarFiltro:{
            type:Boolean,
            required:true,
        },
        listCard:{
            type:Object,
            required:true
        },
        listTable:{
            type:Object,
            required:true
        },
        contadorArreglo:{
            type:Number,
            required:true
        },
        pagination:{
            type:Object,
            required:true
        },
        dataList:{
            type:Object,
            required:true
        },
        title_message_create:{
            type:String,
            required:true
        },
        cardGreen:{
            type:Number,
            required:true
        },
        timeDestroy:{
            type:Number,
            required:true
        }
    },
    data(){
        return{
            cardShow: true,
            listShow: false,
            title_message: '',
            IDLE_TIMEOUT :5,
            idleSecondsTimer:0,
            idleSecondsCounter :0,
            offset: 2,
        }
    },

    methods:{

        modalAdd: function(){
            this.$emit('modalAdd');
        },

        showFilter: function(){
            this.$emit('showModalFilter');
        },

        clearFilrter: function(){
            this.$emit('clearFilter');
        },
        
        openModalDestroy(data){
            this.$emit('modalDelete', data);
        },
        
        openModalEdit(data){
            this.$emit('modalEdit', data);
        },

        switchViewTable: function(){
            this.cardShow = !this.cardShow;
            this.listShow = !this.listShow;
        },

        removeFilter: function(field){
            let cant = document.getElementById("buttons").getElementsByClassName("ri-close-line").length
            this.$emit('removeOptionsFilter', field, cant);
        },

        ocultarAlert: function(){
            $('#alert').hide();
            $("#alertCreate").hide();
        },

        mostrarAlert(){
            $('#alert').show();
        },

        timerAlertShow(){
            this.idleSecondsTimer = window.setInterval(this.CheckIdleTime, 1000);
            this.idleSecondsCounter = 0;
        },

        CheckIdleTime() {
            this.idleSecondsCounter++;
            if (this.idleSecondsCounter >= this.IDLE_TIMEOUT) {
                window.clearInterval(this.idleSecondsTimer);
            }
        },
    },

    computed:{
        isActive(){
            return this.pagination.current_page;
        },
        pagesNumber(){
            if(!this.pagination.to){
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if(from < 1 ){
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page){
                to = this.pagination.last_page;
            }
            var pageArray = [];
            while(from <= to){
                pageArray.push(from);
                from++;
            }
            return pageArray;
        },
    },

    mounted(){
        this.ocultarAlert();
    },
}
</script>