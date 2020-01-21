<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de contatos</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="openModal"><i class="fas fa-user-plus fa-fw"></i> Novo Contato</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nome</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="cont in contacts" :key="cont.id">
                                <td><img :src="getProfilePhoto(cont.photo)" class="img-circle elevation-2" width="30px"></td>
                                <td>{{cont.name}}</td>
                                <td>{{cont.phone}}</td>
                                <td>{{cont.email}}</td>
                                <td>
                                    <a href="#" @click="editModal(cont)"><i class="fa fa-edit"></i></a>
                                    /
                                    <a href="#" @click="deleteContact(cont.id)"><i class="fa fa-trash red"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            <!-- /.card -->
            </div>
        </div>
        <div class="modal fade" id="addNovo" tabindex="-1" role="dialog" aria-labelledby="addNovoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNovoLabel">Novo Contato</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNovoLabel">Editar Contato</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? editarContato() : criarContato()">
                    <div class="modal-body">
                        <div class="form-group">
                            <input v-model="form.name" type="text" name="name"
                            placeholder="Nome"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.email" type="email" name="email"
                            placeholder="Email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.phone" type="phone" name="phone" id="phone"
                            placeholder="Telefone"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                            <has-error :form="form" field="phone"></has-error>
                        </div>
                        <div class="form-group row">
                            <label for="photo" class="col-sm-4">Foto de perfil (obrigatório)</label>
                            <div class="col-sm-10">
                            <input type="file" @change="updateProfile" name="photo" class="form-input">
                            </div>
                            <has-error :form="form" field="photo"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                    </form>
                </div>
            </div>
            </div>
    </div>
</template>

<script>
    export default {
        data() {
            return  {
                editmode:false,
                contacts: {},
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    phone: '',
                    photo: '',
                    iduser: '',
                })
            }
        },
        methods: {
            getProfilePhoto(photo) {
                return "img/profile/" + photo;
            },
            updateProfile(el) {
            // console.log('up');
                let file = el.target.files[0];
                let reader = new FileReader();
                reader.onloadend = (file) => {
                //console.log('RESULT', reader.result)
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            },
            loadContatos() {
                axios.get("api/contact").then(({data}) => (this.contacts = data.data));
            },
            editModal(contact) {
                this.editmode = true;
                this.form.reset();
                $('#addNovo').modal('show');
                this.form.fill(contact);
            },
            deleteContact(id) {
                swal.fire({
                    title: 'Tem certeza?',
                    text: "Esta ação não será desfeita!",
                    type: 'warning',
                    icon: 'Atenção',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, deletar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    //send request to the server
                    if(result.value) {
                        this.form.delete('api/contact/'+id).then(() => {
                            swal.fire(
                                'Excluído',
                                'Contato deletado!',
                                'success'
                            )
                            Fire.$emit('mudouDados');
                        }).catch(() => {
                            swal.fire(
                                'Falha',
                                'Algo deu errado!',
                                'warning'
                            )
                        })
                    }
                })
            },
            openModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNovo').modal('show');
            },
            criarContato() {
                this.form.post('api/contact')
                .then(() => {
                    Fire.$emit('mudouDados'); //we can acess to emit event
                    toast.fire({
                        icon: 'success',
                        title: 'Contato registrado com sucesso!'
                    })
                    $('#addNovo').modal('hide')
                }).catch((error) => {
                    console.log(error);
                })
            },
            editarContato() {
                this.form.put('api/contact/'+this.form.id)
                .then(() => {
                    swal.fire(
                        'Alterado',
                        'Contato alterado!',
                        'success'
                    )
                    Fire.$emit('mudouDados');
                    $('#addNovo').modal('hide')
                }).catch(() => {
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.loadContatos();
            Fire.$on('mudouDados', () => {
                this.loadContatos();
            });
        }
    }
</script>
