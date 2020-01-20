<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lista de usuários</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addNovo"><i class="fas fa-user-plus fa-fw"></i> Novo Usuário</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Tipo</th>
                                <th>Criado em</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{user.id}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td v-if="user.type === '1'">Admin</td>
                                <td v-else>Usuário</td>
                                <td>{{user.created_at}}</td>
                                <td>
                                    <a href="#"><i class="fa fa-edit"></i></a>
                                    /
                                    <a href="#"><i class="fa fa-trash red"></i></a>
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
                        <h5 class="modal-title" id="addNovoLabel">Novo Usuário</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="criarUsuario">
                    <div class="modal-body">
                        <div class="form-group">
                            <input v-model="form.name" type="text" name="name"
                            placeholder="Name"
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
                            <input v-model="form.password" type="password" name="password" id="password"
                            placeholder="****"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>
                        <div class="form-group">
                            <select name="type" v-model="form.type" id="type" class="form-control"
                            :class="{ 'is-invalid': form.errors.has('name') }">
                                <option value="">Tipo</option>
                                <option value="1">Admin</option>
                                <option value="2">Usuário</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>
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
                users: {},
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    type: '',   
                })
            }
        },
        methods: {
            loadUsuarios() {
                axios.get("api/user").then(({data}) => (this.users = data.data));
            },

            criarUsuario() {
                this.form.post('api/user')
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() { //funçao chamada quando o componente é criado
            this.loadUsuarios();
        }
    }
</script>
