<template>
    <div>
        <div class="row">
            <main class="col-md-9">
                <div class="card" v-if="listwsp.length > 0">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="text-muted">
                            <tr class="small text-uppercase">
                            <th scope="col">Lista de Pedidos</th>
                            <th scope="col">Precio</th>
                            <th scope="col" width="100" class="text-center">Cantidad</th>
                            <th></th>
                            <!-- <th scope="col" class="text-right">Opc</th> -->
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in carrito" v-if="item.xmaster == idrest">
                                    <td>
                                        <a :href="'../productos/'+ item.xslug" class="title text-dark">{{item.xprod}}</a>
                                    </td>
                                    <td class="text-lefth">
                                        <var class="text-muted">{{item.xprecio}}</var>
                                    </td>
                                    <td>
                                        <input type="number" v-model="item.xcantidad" @change="cantidadPedidos()" class="form-control">
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-danger btn-sm float-right" @click="removeCart(index)"><i class="fa fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p v-if="restdelivery !=''" class="icontext"><i class="icon text-success fa fa-truck"></i> {{restdelivery}}</p>
                                    </td>
                                    <td colspan="3">
                                        <div class="align-self-end ml-auto">
                                            <a class="btn btn-success float-right" 
                                                :href="'https://wa.me/51'+ restcelular + '?text=Hola, deseo realizar este pedido. '+listwsp +'%0D%0A%0D%0A Gracias'" 
                                                target="../" >
                                                Enviar mi Pedido 
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-if="listwsp.length < 1" class="alert alert-warning text-center" role="alert">
                Tus pedidos se visualizarán aquí. <p>Aún no cuentas con pedidos para este Restaurante.</p>
                <p v-if="restdelivery !=''" class="icontext" style="color: black;"><i class="icon text-success fa fa-truck"></i> {{restdelivery}}</p>
                </div>

                <br>
                <header class="border-bottom mb-4 pb-3">
                    <div class="form-inline">
                        <!-- <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" v-model="buscador">
                            <div class="input-group-append">
                                <button class="btn btn-light mr-2" type="button"><i class="fa fa-search"></i></button>
                            </div>
                        </div> -->
                        <!-- <div>
                            <h2>Cats</h2>
                            <div v-for="(cat,n) in cats">
                                <p>
                                <span class="cat">{{cat.xprod}} {{cat.xprecio}}</span> <button @click="removeCart(n)">Remove</button>
                                </p>
                            </div>
                            
                            <p>
                                <input v-model="newCat"> 
                                <button @click="addProducto()">Add Cat</button>
                            </p>
                        </div> -->
                        <select class="mr-2 form-control" v-model="categoriaid" @change="getCateProd()">
                            <option value="0">Ver toda la Carta</option>
                            <option v-for="(categoria, index) in listCategoria" :value="categoria.id">{{categoria.categoria}} </option>
                        </select>  
                        
                    </div>
                </header>
                            
                <article v-for="(categoria, index) in categorias" class="card">
                    <header class="card-header text-center">
                        <h3>
                            <strong class="card-title mb-4">{{categoria.categoria.replace(/\b\w/g, l => l.toUpperCase())}}</strong>
                        </h3>
                    </header>
                    <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <tr v-for="(item, index) in categoria.productos">
                            <td width="20">
                                <a :href="'../productos/'+ item.slug">
                                    <img v-if="item.portada" class="icon icon-md rounded-circle" :src="'../'+item.portada">
                                    <img v-else class="icon icon-md rounded-circle" :src="'../' + restportada">
                                </a>
                            </td>
                            <td> 
                                <h6 class="title mb-0"><a :href="'../productos/'+ item.slug"> {{item.producto}}  </a>  <span v-if="item.oferta" class="text-warning mr-2" data-toggle="tooltip" title="Oferta/Promoción"><i class="fas fa-tag"></i></span></h6> 
                                <small class="text-muted"><p>{{item.ingredientes}}</p></small>
                                <button class="btn btn-outline-info btn-sm float-right" @click="addProducto(item)">Añadir <i class="fa fa-shopping-cart"></i></button>
                                <a class="btn btn-outline-success btn-sm float-right mr-2" :href="'https://wa.me/51'+ restcelular + '?text=Hola, deseo realizar este pedido. %0D%0A * '+ item.producto + '* %0D%0A *Precio:* S/' + item.precio+ '%0D%0A%0D%0A Gracias'" target="../" >Delivery <i class="fab fa-whatsapp"></i></a>
                                <var class="price text-muted float-right  mr-2">S/ {{item.precio}}</var> 
                            </td>
                        </tr>
                        </tbody></table>
                    </div>
                </article>
                <br>
            </main> <!-- col.// -->
            <aside class="col-md-3">
                <div class="card">
                    <article class="filter-group">
                        <header class="card-header">
                            <a href="#" data-toggle="collapse" data-target="#collapse_1" aria-expanded="true" class="">
                                <i class="icon-control fa fa-chevron-down"></i>
                                <h6 class="title">Novedades</h6>
                            </a>
                        </header>
                        <div class="filter-content collapse show" id="collapse_1" style="">
                            <div class="card-body">
                                <!-- <form class="pb-3">
                                    <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-light" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                    </div>
                                </form>
                                
                                <ul class="list-menu">
                                    <li><a href="#">Promociones  </a></li>
                                    <li><a href="#">Delivery </a>
                                    </li>
                                </ul> -->
                                <figure class="itemside" v-if="restdelivery !=''" >
                                    <div class="aside">
                                        <span class="icon-sm rounded-circle bg-success">
                                            <i class="fa fa-truck white"></i>
                                        </span>
                                    </div>
                                    <figcaption class="info">
                                        <h6 class="title">Delivery</h6>
                                        <p class="text-muted">{{restdelivery}}</p>
                                    </figcaption>
                                </figure>
                            </div>
                        </div>
                    </article> <!-- filter-group  .// -->
                </div> <!-- card.// -->
                <!-- <article class="card card-body">
                    <figure class="itemside" v-if="restdelivery !=''" >
                        <div class="aside">
                            <span class="icon-sm rounded-circle bg-success">
                                <i class="fa fa-truck white"></i>
                            </span>
                        </div>
                        <figcaption class="info">
                            <h6 class="title">Delivery</h6>
                            <p class="text-muted">{{restdelivery}}</p>
                        </figcaption>
                    </figure>
                </article> -->
            </aside> <!-- col.// -->
        </div>
    </div>
</template>

<script>
    import toastr from 'toastr';
    export default {
        props : ['idrest','celular','portada','delivery'],
        data(){
            return{
                restcelular:this.celular,
                restportada:this.portada,
                restdelivery:this.delivery,
                listCategoria:[],
                categorias:[],
                categoriaid:'0',
                buscador:'',

                carrito:[],
                newCat:null,
                pedidos:'',
                listwsp:[]
            }
        },
        created(){
            var urlcategprod = '../catemenu/'+this.idrest
            axios.get(urlcategprod).then(res=>{
                this.categorias = res.data.categprod;
                this.listCategoria = res.data.categprod;
            })
            
        },
        // computed:{
        //     buscarMenu: function () {
        //         return this.categorias.filter((item) => item.categoria.includes(this.buscador));
        //     }
        // },
        methods:{
            getCateProd(){
                // this.valuemultisel = {iglesia:'Buscar...', codigo:'', manual_online:''}
                axios.get('../getcategoria?category='+this.categoriaid+'&key='+this.idrest).then(res=>{
                    this.categorias = res.data.categoria;
                })
            },
            // persist() {
            //     localStorage.name = this.name;
            //     localStorage.age = this.age;
            //     console.log('imaginen que estoy haciendo más cosas...');
            // }
            addProducto(val) {
                // ensure they actually typed something
                // if(!this.newCat) return;
                this.pedidos = {
                    'xmaster':this.idrest,
                    'xid':val.id,
                    'xprod':val.producto,
                    'xprecio':val.precio,
                    'xportada':val.portada,
                    'xslug':val.slug,
                    'xcantidad':'1'
                    
                }
                this.carrito.push(this.pedidos);
                this.newCat = '';
                this.saveCarts();
                toastr.success('Se agregó a la lista');
            },
            removeCart(x) {
                this.carrito.splice(x,1);
                this.saveCarts();
            },
            saveCarts() {
                let parsed = JSON.stringify(this.carrito);
                localStorage.setItem('carrito', parsed);
            },
            cantidadPedidos(){
                this.listwsp = []
                this.carrito.forEach(val => {
                    if (val.xmaster == this.idrest) {
                        this.listwsp.push('%0D%0A • *'+val.xprod+'* | _Cant_=*'+val.xcantidad+'*')
                    }
                });
                this.saveCarts();
            }
            
        },
        mounted() {
            // console.log('Component mounted.')
            // if (localStorage.name) {
            //     this.name = localStorage.name;
            // }
            // if (localStorage.age) {
            //   this.age = localStorage.age;
            // }

            if(localStorage.getItem('carrito')) {
                try {
                    this.carrito = JSON.parse(localStorage.getItem('carrito'));
                } catch(e) {
                    localStorage.removeItem('carrito');
                }
            }
        },
        watch: {
            name(newName) {
            localStorage.name = newName;
            },
            carrito(){
                this.cantidadPedidos();
            }
        }
    }
</script>
