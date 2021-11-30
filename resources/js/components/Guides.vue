<template>
    <general
        titulo="Guias"
        description="Agrega una nueva guia"
        add="Agrega una nueva guia"
        tableTitle="Guias Registradas"
        tableDescription="Edita, filtra o accede a las guias registradas"
        nonRegister="Aún no existen guias registradas"
        :filter="filter"
        :mostrarFiltro="mostrarFiltro"
        :listCard="listCard"
        :listTable="listTable"
        :contadorArreglo="contadorArreglo"
        :pagination="pagination"
        :dataList="dataList"
        :title_message_create="title_message_create"
        :cardGreen="cardGreen"
        :timeDestroy="timeDestroy"
        @showModalFilter="showFilter"
        @removeOptionsFilter="removeFilter"
        @modalAdd="showModalAdd"
        @modalDelete="openModalDestroy"
        @modalEdit="openModalEdit"
        ref="generalView"
    ></general>

    <div class="modal fade" tabindex="-1" id="modal-filter" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="mb-0"><i class="ri-filter-3-line align-top"></i> Filtro de búsqueda</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="#" method="post" accept-charset="utf-8">
						<div class="row" id="fieldsFilter">
                            <div class="col-12 col-md-6">
								<div class="form-group">
									<label for="guide_numberFilter">Nº de guia:</label>
									<input type="text" name="guide_numberFilter" class="form-control" id="guide_numberFilter" placeholder="" v-model="filter.guide_number.value">
								</div>
							</div>
							<div class="col-12 col-md-6">
								<div class="form-group">
									<label for="shipping_dateFilter">Fecha de envio:</label>
                                    <datepicker
                                            name="shipping_dateFilter"
                                            id="shipping_dateFilter"
                                            class="form-control v3dp__datepicker"
                                            v-model="filter.shipping_date.value"
                                            inputFormat="dd/MM/yyyy"
                                            v-bind:locale="es"
                                            :bootstrap-styling="true"
                                    ></datepicker>
								</div>
							</div>
                            <div class="col-12 col-md-6">
								<div class="form-group">
									<label for="country_originFilter">País de origen:</label>
									<input type="text" name="country_originFilter" class="form-control" id="country_originFilter" placeholder="" v-model="filter.country_origin.value">
								</div>
							</div>
                            <div class="col-12 col-md-6">
								<div class="form-group">
									<label for="sender_emailFilter">Email remitente:</label>
									<input type="text" name="sender_emailFilter" class="form-control" id="sender_emailFilter" placeholder="" v-model="filter.sender_email.value">
								</div>
							</div>
                            <div class="col-12 col-md-6">
								<div class="form-group">
									<label for="destination_countryFilter">País destinatario:</label>
									<input type="text" name="destination_countryFilter" class="form-control" id="destination_countryFilter" placeholder="" v-model="filter.destination_country.value">
								</div>
							</div>
                            <div class="col-12 col-md-6">
								<div class="form-group">
									<label for="recipient_emailFilter">Email destinatario:</label>
									<input type="text" name="sender_emailFilter" class="form-control" id="recipient_emailFilter" placeholder="" v-model="filter.recipient_email.value">
								</div>
							</div>
							<div class="col-12 text-right">
								<button type="button" class="button secondary mr-15" @click.prevent="clearFilter">Borrar todo</button>
								<button type="button" class="button main" @click.prevent="selectFilter">Listo</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-sm">
			<form action="">
				<div class="modal-content">
					<div class="modal-header">
						<p class="mb-0">Eliminar</p>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<p class="mb-0"><small>Vamos a eliminar la guia <span class="bold">“{{guide.guide_number}}”</span>. Este cambio no se puede deshacer ¿Estás seguro de que deseas hacerlo?</small></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary btn-sm mr-15" data-dismiss="modal">Cancelar</button>
                    	<button type="submit" class="btn btn-primary btn-sm" @click.prevent="destroy">Eliminar</button>
					</div>		
				</div>
			</form>
		</div>
	</div>

    <div class="modal fade" tabindex="-1" id="modal-guide" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="mb-0">{{modalTitle}}</h2>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
					    <div class="row mt-15">
                            <h4 class="mb-0 col-12">Datos de la guia</h4>
                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.guide_number}">
									<label for="guide_number">Nº de guia:</label>
									<input type="text" name="guide_number" class="form-control" :class="{'form-alert':invalid.guide_number}" id="guide_number" placeholder="Nº de guia" v-model="guide.guide_number">
                                    <p class="message" v-for="(e_guide_number, index) in errors.guide_number" :key="index">{{e_guide_number}}</p>
								</div>
							</div>

                            <div class="col-12 col-md-6">
								<div class="form-group" :class="{'error':invalid.shipping_date}">
									<label for="shipping_date">Fecha de envío:</label>
                                    <datepicker
                                            name="shipping_date"
                                            id="shipping_date"
                                            class="form-control v3dp__datepicker"
                                            v-model="guide.shipping_date"
                                            inputFormat="dd/MM/yyyy"
                                            v-bind:locale="es"
                                            :bootstrap-styling="true"
                                    ></datepicker>
                                    <p class="message" v-for="(e_shipping_date, index) in errors.shipping_date" :key="index">{{e_shipping_date}}</p>
								</div>
							</div>

                            <h4 class="mb-0 col-12">Datos de envio</h4><br>
                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.country_origin}">
									<label for="country_origin">País de origen:</label>
									<input type="text" name="country_origin" class="form-control" :class="{'form-alert':invalid.country_origin}" id="country_origin" placeholder="País de origen" v-model="guide.country_origin">
                                    <p class="message" v-for="(e_country_origin, index) in errors.country_origin" :key="index">{{e_country_origin}}</p>
								</div>
							</div>

                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.sender_name}">
									<label for="sender_name">Nombre de remitente:</label>
									<input type="text" name="sender_name" class="form-control" :class="{'form-alert':invalid.sender_name}" id="sender_name" placeholder="Nombre de remitente:" v-model="guide.sender_name">
                                    <p class="message" v-for="(e_sender_name, index) in errors.sender_name" :key="index">{{e_sender_name}}</p>
								</div>
							</div>

                            <div class="col-12 col-md-12">
                                <div class="form-group" :class="{'error':invalid.sender_address}">
									<label for="sender_address">Dirección de remitente:</label>
									<input type="text" name="sender_address" class="form-control" :class="{'form-alert':invalid.sender_address}" id="sender_address" placeholder="Dirección de remitente:" v-model="guide.sender_address">
                                    <p class="message" v-for="(e_sender_address, index) in errors.sender_address" :key="index">{{e_sender_address}}</p>
								</div>
							</div>

                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.sender_phone}">
									<label for="sender_phone">Teléfono remitente:</label>
									<input type="text" name="sender_phone" class="form-control" :class="{'form-alert':invalid.sender_phone}" id="sender_phone" placeholder="Teléfono remitente" v-model="guide.sender_phone">
                                    <p class="message" v-for="(e_sender_phone, index) in errors.sender_phone" :key="index">{{e_sender_phone}}</p>
								</div>
							</div>

                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.sender_email}">
									<label for="sender_email">Correo eléctronico remitente:</label>
									<input type="text" name="sender_email" class="form-control" :class="{'form-alert':invalid.sender_email}" id="country_origin" placeholder="Correo eléctronico remitente" v-model="guide.sender_email">
                                    <p class="message" v-for="(e_sender_email, index) in errors.sender_email" :key="index">{{e_sender_email}}</p>
								</div>
							</div>

                            <h4 class="mb-0 col-12">Datos de recibo</h4><br>
                           
                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.destination_country}">
									<label for="destination_country">País de destino:</label>
									<input type="text" name="destination_country" class="form-control" :class="{'form-alert':invalid.destination_country}" id="destination_country" placeholder="País de destino" v-model="guide.destination_country">
                                    <p class="message" v-for="(e_destination_country, index) in errors.destination_country" :key="index">{{e_destination_country}}</p>
								</div>
							</div>

                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.recipient_name}">
									<label for="recipient_name">Nombre de destinatario:</label>
									<input type="text" name="recipient_name" class="form-control" :class="{'form-alert':invalid.recipient_name}" id="recipient_name" placeholder="Nombre de destinatario:" v-model="guide.recipient_name">
                                    <p class="message" v-for="(e_recipient_name, index) in errors.recipient_name" :key="index">{{e_recipient_name}}</p>
								</div>
							</div>

                            <div class="col-12 col-md-12">
                                <div class="form-group" :class="{'error':invalid.recipient_address}">
									<label for="recipient_address">Dirección de destinatario:</label>
									<input type="text" name="recipient_address" class="form-control" :class="{'form-alert':invalid.recipient_address}" id="recipient_address" placeholder="Dirección de destinatario:" v-model="guide.recipient_address">
                                    <p class="message" v-for="(e_recipient_address, index) in errors.recipient_address" :key="index">{{e_recipient_address}}</p>
								</div>
							</div>

                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.recipient_phone}">
									<label for="recipient_phone">Teléfono destinatario:</label>
									<input type="text" name="recipient_phone" class="form-control" :class="{'form-alert':invalid.recipient_phone}" id="recipient_phone" placeholder="Teléfono destinatario" v-model="guide.recipient_phone">
                                    <p class="message" v-for="(e_recipient_phone, index) in errors.recipient_phone" :key="index">{{e_recipient_phone}}</p>
								</div>
							</div>

                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.recipient_email}">
									<label for="recipient_email">Correo eléctronico destinatario:</label>
									<input type="text" name="recipient_email" class="form-control" :class="{'form-alert':invalid.recipient_email}" id="recipient_email" placeholder="Correo eléctronico destinatario" v-model="guide.recipient_email">
                                    <p class="message" v-for="(e_recipient_email, index) in errors.recipient_email" :key="index">{{e_recipient_email}}</p>
								</div>
							</div>

                            <h4 class="mb-0 col-12">Total guia</h4><br>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-6" style="float: right;">
                                <div class="form-group" :class="{'error':invalid.total}">
                                    <label for="total">Total:</label>
                                    <vue-mask
                                        type="text"
                                        name="total"
                                        id="total"
                                        class="form-control superMoney"
                                        required
                                        placeholder="$32,500.00"
                                        v-model="guide.total"
                                        :class="{'form-alert':invalid.total}"
                                        mask="###,###,##0.00"
                                        :raw="false"
                                        :options="options.money"
                                    >
                                    </vue-mask>
                                    <p class="message" v-for="(e_total, index) in errors.total" :key="index">{{e_total}}</p>
                                </div>
                            </div>

							<div class="col-12 mt-15" :class="{'text-right':createOrEdit=='guardar'}">
                                <button v-if="createOrEdit=='guardar'" type="button" class="button main float-right" @click.prevent="addOrCreateGuide">Crear guia</button>
                                <button v-if="createOrEdit=='editar'" type="button" class="button main float-right" @click.prevent="addOrCreateGuide">Guardar guia</button>
								<button type="button" class="button secondary mr-15" data-dismiss="modal">Cancelar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

    import moment from 'moment';    
    import Datepicker from 'vue3-datepicker';
    import General from './generalView'
    import vueMask from "vue-jquery-mask";
    import { es } from 'date-fns/locale'
    import { ref } from 'vue'

    export default {
        name:'invoices',
        components: {
            Datepicker,
            General,
            vueMask, 
        },
        data() {
            return {
                guides:{},
                guide:{
                    guide_number:'',
                    shipping_date:ref(new Date()),
                    country_origin:'',
                    sender_name:'',
                    sender_address:'',
                    sender_phone:'',
                    sender_email:'',
                    destination_country:'',
                    recipient_name:'',
                    recipient_address:'',
                    recipient_phone:'',
                    recipient_email:'',
                    total:'',
                },
                filter:{
                    guide_number:{
                        title: 'Nº de guia',
                        value:''
                    },
                    shipping_date:{
                        title: 'Fecha de envío',
                        value:ref()
                    },
                    country_origin:{
                        title: 'País de origen',
                        value:''
                    },
                    sender_email:{
                        title: 'Email remitente',
                        value:''
                    },
                    destination_country:{
                        title: 'País de destino',
                        value:''
                    },
                    recipient_email:{
                        title: 'Email destinatario',
                        value:''
                    },
                },
                modalTitle:'',
                es:es,
                mostrarFiltro: false,
                dataList:{},
                listCard: {},
                listTable: {},
                pagination:{
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                contadorArreglo:0,
                invalid:{
                    guide_number:0,
                    shipping_date:0,
                    country_origin:0,
                    sender_name:0,
                    sender_address:0,
                    sender_phone:0,
                    sender_email:0,
                    destination_country:0,
                    recipient_name:0,
                    recipient_address:0,
                    recipient_phone:0,
                    recipient_email:0,
                    total:0,
                },
                errors:[],
                options: {
                    money: {
                        reverse: true,
                        selectOnFocus: true,
                    },
                    date: {
                        placeholder: "__/__/____",
                        clearIfNotMatch: true,
                    },
                },
                createOrEdit:"guardar",
                title_message_create:'',
                cardGreen:0,
                timeDestroy: 0,

            }
        },
        created() {        
            this.getList();
        },
        methods: {
            /**
			* Routine Show filter modal
			* @author Jose Tovar
			* @created 14-11-2021
			* @param  {void}
			* @return  {boolean}
			*/
            showFilter: function()
            {
                $('#modal-filter').modal('show');
            },
            
            /**
			* Routine select filters
			* @author Jose Tovar
			* @created 14-11-2021
			* @param  {void}
			* @return  {boolean}
			*/
            selectFilter: function()
            {
                this.mostrarFiltro = true;
                $('#modal-filter').modal('hide');
            },

            /**
			* Routine clear filters
			* @author Jose Tovar
			* @created 14-11-2021
			* @param  {void}
			* @return  {boolean}
			*/
            clearFilter: function()
            {
                for (let key in this.filter){
                    this.filter[key].value = '';
                }
                this.mostrarFiltro = false;
            },

            /**
			* Routine remove filters
			* @author Jose Tovar
			* @created 14-11-2021
			* @param  {string} field
            * @param  {number} cant
			* @return  {void}
			*/
            removeFilter: function(field, cant)
            {
                this.filter[field].value = '';
                if (cant - 1 == 0) {
                    this.mostrarFiltro = false;
                }
            },

            getList(page=''){
                let urlList = '/api/guides?page='+page;
                this.$axios.get(urlList).then(response=>{
                    this.listCard = response.data.guideFormat.cardData;
                    this.listTable = response.data.guideFormat.listData;
                    this.contadorArreglo = response.data.pagination.total;
                    this.pagination = response.data.pagination;
                    this.dataList = response.data.guideList.data;
                    
                });
            },

            showModalAdd(){
                this.modalTitle = "Agregar Guia"
                $('#modal-guide').modal('show');
            },

            addOrCreateGuide(){
                this.reiniciaMensajesError();
                let saveData = {
                    id: typeof this.guide.id !== 'undefined' ? this.guide.id : '',
                    guide_number: this.guide.guide_number,
                    shipping_date: moment(this.guide.shipping_date).format(moment.HTML5_FMT.DATE),
                    country_origin: this.guide.country_origin,
                    sender_name: this.guide.sender_name,
                    sender_address: this.guide.sender_address,
                    sender_phone: this.guide.sender_phone,
                    sender_email: this.guide.sender_email,
                    destination_country: this.guide.destination_country,
                    recipient_name: this.guide.recipient_name,
                    recipient_address: this.guide.recipient_address,
                    recipient_phone: this.guide.recipient_phone,
                    recipient_email: this.guide.recipient_email,
                    total: this.guide.total.replace(/[^0-9\.-]+/g,""),
                }

                if (saveData.id == ''){
                    return this.addGuide(saveData)
                }else{
                    return this.updateGuide(saveData)
                }
            },

            addGuide(saveData){
                this.$axios.post('/api/guides/', saveData).then(response=>{
                    if (response && response.data.statusCode == 200){
                        this.closeModal()
                        this.cardGreen=response.data.id;
                        $("#alertCreate").show();
                        this.getList();
                        this.title_message_create = 'Agregamos una guia con éxito.'
                        this.timeDestroy = setTimeout(()=>{
                            $("#alertCreate").hide();
                        },4000)
                        this.cardGreenChange();
                    }else{
                        console.log(response);
                    }
                }).catch((error)=> {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors
                        console.log('aqui')
                        this.mostrarErrores()
                    }else{
                        console.log(error);
                    }
                });
            },

            updateGuide(saveData){
                this.$axios.put('/api/guides/'+saveData.id, saveData).then(response=>{
                    if (response && response.data.statusCode == 200){
                        this.closeModal()
                        this.getList()
                    }else{
                        console.log(response);
                    }
                }).catch((error)=> {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors
                        console.log('aqui')
                        this.mostrarErrores()
                    }else{
                        console.log(error);
                    }
                });
            },

            mostrarErrores(){
                console.log('mostrar')
                this.reiniciaMensajesError();
                
                console.log(this.errors)
                for(let error in this.errors) {
                    
                    switch(error){
                        case 'guide_number':
                            
                            this.invalid.guide_number = 1
                        break;
                        case 'shipping_date':
                            this.invalid.shipping_date = 1
                        break;
                        case 'country_origin':
                            this.invalid.country_origin = 1
                        break;
                        case 'sender_name':
                            this.invalid.sender_name = 1
                        break;
                        case 'sender_address':
                            this.invalid.sender_address = 1
                        break;
                        case 'sender_phone':
                            this.invalid.sender_phone = 1
                        break;
                        case 'sender_email':
                            this.invalid.sender_email = 1
                        break;
                        case 'destination_country':
                            this.invalid.destination_country = 1
                        break;
                        case 'recipient_name':
                            this.invalid.recipient_name = 1
                        break;
                        case 'recipient_address':
                            this.invalid.recipient_address = 1
                        break;
                        case 'recipient_phone':
                            this.invalid.recipient_phone = 1
                        break;
                        case 'recipient_email':
                            this.invalid.recipient_email = 1
                        break;
                        case 'total':
                            this.invalid.total = 1
                        break;
                    }
                }
            },

            reiniciaMensajesError(){
                for(let inval in this.invalid) {
                    this.invalid[inval]=0;
                }
            },

            closeModal(){
                this.modalTitle = ""
                $('#modal-guide').modal('hide');
            },

            cardGreenChange(){
				this.timeDestroy = setTimeout(()=>{
					this.cardGreen = 0;
				},3000)
			},

            number_format(amount, decimals) {
                amount += "";
                amount = parseFloat(amount.replace(/[^0-9\.]/g, ""));
                decimals = decimals || 0;
                if (isNaN(amount) || amount === 0) return parseFloat(0).toFixed(decimals);
                amount = "" + amount.toFixed(decimals);
                var amount_parts = amount.split("."),
                    regexp = /(\d+)(\d{3})/;
                while (regexp.test(amount_parts[0]))
                    amount_parts[0] = amount_parts[0].replace(regexp, "$1" + "," + "$2");
                return amount_parts.join(".");
            },

            selectRegister(data){
                let a = this.dataList.map(function(e) { return e.id; }).indexOf(data);
                return this.guide = this.dataList[a];
            },

            openModalDestroy(data){
                this.selectRegister(data);
                $('#modalDelete').modal('show');
            },

            destroy(){
                $('#modalDelete').modal('hide');
                this.title_message = "Eliminamos la guia con éxito.";
                this.$refs.generalView.mostrarAlert()
                this.timeDestroy = setTimeout(()=>{
                    this.$axios.delete('/api/guides/'+this.guide.id).then(response => {
                        this.getList();
                        this.$refs.generalView.ocultarAlert();
                    }).catch(function (error) {
                        console.log(error);
                    });
                }, 5000);
                this.$refs.generalView.timerAlertShow();
            },

            openModalEdit(data){
                this.selectRegister(data);
                this.modalTitle = "Editar Guia"
                this.createOrEdit= 'editar';
                this.guide.shipping_date = ref(new Date(this.guide.shipping_date .replace(/-/g, '\/')));
                $('#modal-guide').modal('show');
            },

            

        },
        computed:{
            
        }
    };
</script>
