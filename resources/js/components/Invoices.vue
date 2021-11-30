<template>
    <General
        titulo="Facturas"
        description="Agrega una nueva factura"
        add="Agrega una nueva factura"
        tableTitle="Facturas Registradas"
        tableDescription="Edita, filtra o accede a las facturas registradas"
        nonRegister="Aún no existen facturas registradas"
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
    ></General>

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
						<p class="mb-0"><small>Vamos a eliminar la factura <span class="bold">“{{invoice.secuencial}}”</span>. Este cambio no se puede deshacer ¿Estás seguro de que deseas hacerlo?</small></p>
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
                            <div class="row mb-15">
                                <div v-for="(value, key, index) in guides" :key="index" class="col-12 mb-15">
                                    <div class="caja xs lista">
                                        <div class="barra-superior">
                                            <div v-for="(val, name) in value.body" :key="name">
                                                <div v-if="name == ''">
                                                    <input type="checkbox" 
                                                        v-on="handleEvent"
                                                        :id="val"
                                                        v-model="checkedGuides[val]"
                                                        :value="val"  
                                                    >
                                                </div>
                                                <div class="small">{{name}}</div>                                
                                                <div v-if="name != ''">{{val}}</div>                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 class="mb-0 col-12">Datos de facturación</h4>
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.establishment}">
									<label for="establishment">Establecimiento:</label>
									<input type="text" name="establishment" class="form-control" :class="{'form-alert':invalid.establishment}" id="establishment" placeholder="Establecimiento" v-model="invoice.establishment">
                                    <p class="message" v-for="(e_establishment, index) in errors.establishment" :key="index">{{e_establishment}}</p>
								</div>
							</div>
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.emission_point}">
									<label for="emission_point">Punto de emisión:</label>
									<input type="text" name="emission_point" class="form-control" :class="{'form-alert':invalid.emission_point}" id="emission_point" placeholder="Punto de emisión" v-model="invoice.emission_point">
                                    <p class="message" v-for="(e_emission_point, index) in errors.emission_point" :key="index">{{e_emission_point}}</p>
								</div>
							</div>
                            
                            <div class="col-12 col-md-6">
                                <div class="form-group" :class="{'error':invalid.secuencial}">
									<label for="secuencial">Secuencia:</label>
									<input type="text" name="secuencial" class="form-control" :class="{'form-alert':invalid.secuencial}" id="secuencial" placeholder="Secuencia" v-model="invoice.secuencial">
                                    <p class="message" v-for="(e_secuencial, index) in errors.secuencial" :key="index">{{e_secuencial}}</p>
								</div>
							</div>
                            
                            <div class="col-12 col-md-6">
								<div class="form-group" :class="{'error':invalid.date_issue}">
									<label for="date_issue">Fecha de emisión:</label>
                                    <datepicker
                                            name="date_issue"
                                            id="date_issue"
                                            class="form-control v3dp__datepicker"
                                            v-model="invoice.date_issue"
                                            inputFormat="dd/MM/yyyy"
                                            v-bind:locale="es"
                                            :bootstrap-styling="true"
                                    ></datepicker>
                                    <p class="message" v-for="(e_date_issue, index) in errors.date_issue" :key="index">{{e_date_issue}}</p>
								</div>
							</div>
                            
                            <div class="col-12 col-sm-6 col-md-4 col-lg-6" style="float: right;">
                                <div class="form-group" :class="{'error':invalid.subtotal}">
                                    <label for="total">Sub Total:</label>
                                    <vue-mask
                                        type="text"
                                        name="subtotal"
                                        id="subtotal"
                                        class="form-control superMoney"
                                        required
                                        placeholder="$32,500.00"
                                        v-model="invoice.subtotal"
                                        :class="{'form-alert':invalid.subtotal}"
                                        mask="###,###,##0.00"
                                        :raw="false"
                                        :options="options.money"
                                        readonly
                                    >
                                    </vue-mask>
                                    <p class="message" v-for="(e_subtotal, index) in errors.subtotal" :key="index">{{e_subtotal}}</p>
                                </div>
                            </div>
                            
                            <div class="col-12 col-sm-6 col-md-4 col-lg-6" style="float: right;">
                                <div class="form-group" :class="{'error':invalid.taxes}">
                                    <label for="taxes">Impuesto 12%:</label>
                                    <vue-mask
                                        type="text"
                                        name="taxes"
                                        id="taxes"
                                        class="form-control superMoney"
                                        required
                                        placeholder="$32,500.00"
                                        v-model="invoice.taxes"
                                        :class="{'form-alert':invalid.taxes}"
                                        mask="###,###,##0.00"
                                        :raw="false"
                                        :options="options.money"
                                        readonly
                                    >
                                    </vue-mask>
                                    <p class="message" v-for="(e_taxesl, index) in errors.taxes" :key="index">{{e_taxes}}</p>
                                </div>
                            </div>
                            
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
                                        v-model="invoice.total"
                                        :class="{'form-alert':invalid.total}"
                                        mask="###,###,##0.00"
                                        :raw="false"
                                        :options="options.money"
                                        readonly
                                    >
                                    </vue-mask>
                                    <p class="message" v-for="(e_total, index) in errors.total" :key="index">{{e_total}}</p>
                                </div>
                            </div>
							<div class="col-12 mt-15" :class="{'text-right':createOrEdit=='guardar'}">
                                <button v-if="createOrEdit=='guardar'" id="save" type="button" class="button main float-right disabled" disabled @click.prevent="addOrCreateInvoice">Generar factura</button>
                                <button v-if="createOrEdit=='editar'" type="button" class="button main float-right" @click.prevent="addOrCreateInvoice">Guardar factura</button>
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
                Invoices:{},
                invoice:{
                    establishment:'',
                    emission_point:'',
                    secuencial:'',
                    date_issue:ref(new Date()),
                    subtotal:'',
                    taxes:'',
                    total:''
                },
                guides:{},
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
                    establishment:0,
                    emission_point:0,
                    secuencial:0,
                    date_issue:0,
                    subtotal:0,
                    taxes:0,
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
                iconAddGuia: true,
                selectAll: false,
                selected: [],
                dataAll:[],
                handleEvent:{
                    change: ($event) => {
                        this.onChanges($event),
                        this.sumSubTotalGuide
                    }
                },
                checkedGuides:[],
                checkedValues: [],
                seleccionados:0,
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
                let urlList = '/api/invoices?page='+page;
                this.$axios.get(urlList).then(response=>{
                    this.listCard = response.data.invoiceFormat.cardData;
                    this.listTable = response.data.invoiceFormat.listData;
                    this.contadorArreglo = response.data.pagination.total;
                    this.pagination = response.data.pagination;
                    this.dataList = response.data.invoiceList.data;
                    this.guides = response.data.guides
                    
                });
            },

            showModalAdd(){
                this.modalTitle = "Agregar Guia"
                this.getGuidesWithOutInvoices();
                $('#modal-guide').modal('show');
            },

            addOrCreateInvoice(){
                this.reiniciaMensajesError();
                let saveData = {
                    id: typeof this.invoice.id !== 'undefined' ? this.invoice.id : '',
                    establishment: this.invoice.establishment,                    
                    emission_point: this.invoice.emission_point,
                    secuencial: this.invoice.secuencial,
                    date_issue: moment(this.invoice.date_issue).format(moment.HTML5_FMT.DATE),
                    subtotal: this.invoice.subtotal.replace(/[^0-9\.-]+/g,""),
                    taxes: this.invoice.taxes.replace(/[^0-9\.-]+/g,""),
                    total: this.invoice.total.replace(/[^0-9\.-]+/g,""),
                    guides: this.dataAll,
                }

                if (saveData.id == ''){
                    
                    return this.addInvoice(saveData)
                }else{
                    return this.updateInvoice(saveData)
                }
            },

            addInvoice(saveData){
                this.$axios.post('/api/invoices/', saveData).then(response=>{
                    if (response && response.data.statusCode == 200){
                        this.closeModal()
                        this.cardGreen=response.data.id;
                        $("#alertCreate").show();
                        this.getList();
                        this.title_message_create = 'Se generó una factura con éxito.'
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

            updateInvoice(saveData){
                this.$axios.put('/api/invoices/'+saveData.id, saveData).then(response=>{
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
                        case 'establishment':                            
                            this.invalid.establishment = 1
                        break;
                        case 'emission_point':
                            this.invalid.emission_point = 1
                        break;
                        case 'secuencial':
                            this.invalid.secuencial = 1
                        break;
                        case 'date_issue':
                            this.invalid.date_issue = 1
                        break;
                        case 'subtotal':
                            this.invalid.subtotal = 1
                        break;
                        case 'taxes':
                            this.invalid.taxes = 1
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
                return this.invoice = this.dataList[a];
            },

            openModalDestroy(data){
                this.selectRegister(data);
                $('#modalDelete').modal('show');
            },

            destroy(){
                $('#modalDelete').modal('hide');
                this.title_message = "Eliminamos la factura con éxito.";
                this.$refs.generalView.mostrarAlert()
                this.timeDestroy = setTimeout(()=>{
                    this.$axios.delete('/api/invoices/'+this.invoice.id).then(response => {
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
                this.modalTitle = "Editar factura"
                this.createOrEdit= 'editar';
                this.invoice.date_issue = ref(new Date(this.invoice.date_issue .replace(/-/g, '\/')));
                console.log('data')
                console.log(data)

                this.selected = invoice.guides;
                console.log('selected')
                console.log(this.selected)
                $('#modal-guide').modal('show');
            },

            openGuia(){
                $('#guias').collapse("show");
                this.iconAddGuia = false;
            },

            objetConvert()
            {
                let arr= this.checkedValues;                
                this.dataAll = arr.map((x)=> {
                    let obj= this.filterIt(this.guides,x)
                    console.log(obj[0]['Total'])                     
                    return  {
                        guide_id:x, 
                        total_guide:parseFloat(parseFloat(obj[0].Total).toFixed(2)), 
                    }
                });
                console.log(this.dataAll)
            },

            desactiveButton()
            {
                $('#save').prop('disabled', false);
                document.getElementById("save").classList.remove("disabled");
            },

            activeButton()
            {
                $('#save').prop('disabled', true);
                document.getElementById("save").classList.add("disabled");
            },

            onChanges(event){
                this.seleccionCheck(event.target.value);
                this.objetConvert();
                let valueCheck = event.target.checked;
                if (valueCheck === true) {
                    this.desactiveButton();
                } else {
                    if (this.dataAll.length < 1){
                        this.activeButton();
                    }
                    
                }
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

            getGuidesWithOutInvoices(){
                this.$axios.get('/api/invoices/guides').then(response => {
                    this.guides = response.data.guides;
                }).catch(function (error) {
                    console.log(error);
                });
            },

            seleccionCheck(id){
                let existeInarray = this.checkedValues.indexOf(id)
               //chekeado
               if(this.checkedGuides[id]){
                    if(existeInarray===-1)
                        this.checkedValues.push(id)
               }else{
                    //No chekeado
                   if(existeInarray >-1)
                        this.checkedValues.splice(existeInarray, 1);
               }
               this.seleccionados = this.checkedValues.length
            },

            filterIt(arr, searchKey) {
                return arr.filter(x => x.id == searchKey).map(x => x.body);
            }
        },
        computed:{
            sumSubTotalGuide(){
                let subTotalGuide = this.dataAll.reduce(function(accumulator, currentValue) {
                    return accumulator + currentValue.total_guide;
                },0)
                let taxesGuide = parseFloat(subTotalGuide) * 0.12;
                let totalGuide = parseFloat(subTotalGuide) + parseFloat(taxesGuide, 2);
                this.invoice.subtotal = this.number_format(subTotalGuide, 2);
                this.invoice.taxes = this.number_format(taxesGuide, 2);
                this.invoice.total = this.number_format(totalGuide, 2)
            },
        }
    };
</script>

