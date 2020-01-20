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
                                <td>{{cont.photo}}</td>
                                <td>{{cont.name}}</td>
                                <td>{{cont.phone}}</td>
                                <td>{{cont.email}}</td>
                                <td>
                                    <a href="#"><i class="fa fa-edit" @click="editModal(cont)"></i></a>
                                    /
                                    <a href="#"><i class="fa fa-trash red" @click="deleteUser(cont.id)"></i></a>
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
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Salvar</button>
                </div>
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
                    
                })
            }
        },
        methods: {
            loadContatos() {
                axios.get("api/contact").then(({data}) => (this.contacts = data.data));
            },
            editModal(contact) {
                this.editmode = true;
                this.form.reset();
                $('#addNovo').modal('show');
                this.form.fill(contact);
            },
            openModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNovo').modal('show');
            },
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            
        }
    }
</script>
