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
                        src="'./img/profile.png'"
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
                          <input type="text" v-model="form.name" class="form-control" id="inputName">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" v-model="form.email" class="form-control" id="inputEmail">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Senha</label>
                        <div class="col-sm-10">
                          <input type="text" v-model="form.password" class="form-control" id="inputSenha" placeholder="***">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputType" class="col-sm-2 col-form-label">Tipo</label>
                        <div class="col-sm-10">
                          <select name="type" v-model="form.type" id="type" class="form-control"
                            :class="{ 'is-invalid': form.errors.has('name') }">
                            <option value="">Tipo</option>
                            <option value="1">Admin</option>
                            <option value="2">Usuário</option>
                        </select>
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
          updateInfo() {
            this.form.put('api/profile/').then(()=> {

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
          }
        },
        created() { //http request to server and get the information
            axios.get('api/profile').then(({data}) => (this.form.fill(data)));
        }
    }
</script>
