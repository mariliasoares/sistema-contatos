<template>
    <div class="container">
        <section class="content-header">
            <div class="container-fluid">
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            :src="getProfilePhoto()"
                            style="background-image:url('./img/profile.png')"
                            alt="picture">
                        </div>
                        <!--<h3 class="profile-username text-center">Nina Mcintire</h3>
                        <p class="text-muted text-center">Software Engineer</p>-->
                    </div>
                    <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-9">
                <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Nome</label>
                        <div class="col-sm-10">
                          <input type="name" v-model="form.name" class="form-control" id="inputName" 
                          placeholder="Nome" :class="{ 'is-invalid': form.errors.has('name') }">
                          <has-error :form="form" field="name"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" v-model="form.email" class="form-control" id="inputEmail" 
                          placeholder="Email"  :class="{ 'is-invalid': form.errors.has('email') }">
                          <has-error :form="form" field="email"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputType" class="col-sm-2 col-form-label">Tipo</label>
                        <div class="col-sm-10">
                          <select type="type" name="type" v-model="form.type" id="type" class="form-control"
                            :class="{ 'is-invalid': form.errors.has('type') }">
                            <has-error :form="form" field="email"></has-error>
                            <option value="">Tipo</option>
                            <option value="1">Admin</option>
                            <option value="2">Usuário</option>
                        </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="password" class="col-sm-7 col-form-label">Senha (deixe em branco se não for mudar)</label>
                        <div class="col-sm-5">
                          <input type="password" v-model="form.password" class="form-control" id="password" placeholder="Senha"
                          :class="{ 'is-invalid': form.errors.has('password') }">
                          <has-error :form="form" field="password"></has-error>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="photo" class="col-sm-2 col-form-label">Foto de perfil</label>
                        <div class="col-sm-10">
                          <input type="file" @change="updateProfile" name="photo" class="form-input">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" @click.prevent="updateInfo" class="btn btn-success">Salvar</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>
        </section>
    </div>
</template>

<script>
    export default {
        data() { //every component should return a data
            return {
                form: new Form({
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    photo: '',
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
          getProfilePhoto() {
            return "img/profile/" + this.form.photo;
          },
          updateInfo() {
            this.form.put('api/profile/').then(()=> {
              swal.fire(
                  'Alterado',
                  'Cadastro alterado!',
                  'success'
              )
              Fire.$emit('mudouPerfil');
            }).catch(() => {
              
            })
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
          loadPerfil(){
            axios.get('api/profile').then(({data}) => (this.form.fill(data)));
          }
        },
        created() { //http request to server and get the information
            this.loadPerfil();
            Fire.$on('mudouPerfil', () => {
              this.loadPerfil();
            });
        }
    }
</script>
