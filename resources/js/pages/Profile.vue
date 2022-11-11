<template>
  <div>
    <v-card>
      <v-breadcrumbs divider=">" large :items="items"></v-breadcrumbs>
    </v-card>

    <v-container class="grey lighten-5">
      <v-row no-gutters>
        <v-col cols="12" sm="6">
          <v-card class="pa-2" tile>
            <v-layout column>
              <v-card :loading="profileupdating">
                <v-card-text class="customcardtext">
                  <div class="avatararea">
                    <v-hover v-slot="{ hover }">
                      <div style="display: flex; justify-content: center">
                        <v-avatar
                          v-if="user.avatar == null"
                          size="96"
                          style="
                            background-color: darkgreen;
                            margin-bottom: 10px;
                            color: white;
                            margin-top: 5px;
                            margin-left: 5px;
                          "
                        >
                          <v-icon dark x-large> mdi-account-circle </v-icon>
                        </v-avatar>
                        <v-avatar v-else size="96" style="margin-bottom: 10px">
                          <img
                            class="avatarimg"
                            :src="user.avatar"
                            :alt="user.name"
                          />
                        </v-avatar>
                        <v-expand-transition>
                          <div
                            v-if="hover"
                            class="changeavatarhover"
                            @click="openAvatarUpload"
                          >
                            <input
                              type="file"
                              style="display: none"
                              ref="avatarfile"
                              @change="handleFileUpload($event)"
                            />
                            <div class="avataruploaddiv">
                              <v-icon large color="gray darken-2">
                                mdi-arrow-up-bold-box-outline
                              </v-icon>
                            </div>
                          </div>
                        </v-expand-transition>
                      </div>
                    </v-hover>
                  </div>

                  <div v-if="changepassword">
                    <v-alert v-if="hasalert" dense text :type="alert.type">
                      {{ alert.text }}
                    </v-alert>

                    <v-text-field
                      v-model="form.currentpassword"
                      label="Current Password"
                    >
                    </v-text-field>

                    <v-text-field
                      v-model="form.newpassword"
                      label="New Password"
                    >
                    </v-text-field>

                    <v-text-field
                      v-model="form.newpasswordconfirm"
                      label="Confirm New Password"
                    >
                    </v-text-field>
                    <div class="prflbtn">
                      <v-btn
                        color="teal lighten-2"
                        elevation="2"
                        :loading="passwordupdating"
                        :disabled="
                          form.currentpassword == null ||
                          form.newpassword == null ||
                          form.newpasswordconfirm == null
                        "
                        @click="updatePassword"
                      >
                        {{ $t("updatePassword") }}
                      </v-btn>
                    </div>
                    <div class="prflbtn">
                      <v-btn
                        color="deep-orange accent-3"
                        elevation="2"
                        @click="changepassword = false"
                        >{{ $t("cancel") }}</v-btn
                      >
                    </div>
                  </div>

                  <div v-else>
                    <v-text-field
                      v-model="user.name"
                      disabled
                      :label="lang.name"
                    >
                    </v-text-field>

                    <v-text-field
                      v-model="user.email"
                      disabled
                      :label="lang.email"
                    >
                    </v-text-field>

                    
                    <div class="market_line">
                      <b>{{ $t("marketName") }} :</b>
                      <p v-if="market!= null">{{market.name}} </p>
                      <p v-else>-</p>
                    </div>

                  
                  </div>

                  <div class="prflbtn">
                    <v-btn
                      v-if="!changepassword"
                      color="teal lighten-2"
                      elevation="2"
                      @click="changepassword = true"
                    >
                      {{ $t("updatePassword") }}</v-btn
                    >
                  </div>
                  <div style="height: 20px"></div>
                </v-card-text>
              </v-card>
            </v-layout>
          </v-card>
        </v-col>
        <v-col cols="12" sm="6">
          <v-card
            class="pa-2"
            outlined
            tile
            v-if="cropprocess == false"
            :loading="accountactivitiesloading"
          >
            <v-card-title>{{ $t("accountActivities") }} </v-card-title>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">
                      {{ $t("event") }}
                    </th>
                    <th class="text-left">{{ $t("systemTime") }} (UTC 0)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in accountactivities" :key="item.id">
                    <td>
                      <div v-if="item.type == 0">
                        {{ $t("loggedOutOfDashboard") }}
                      </div>
                      <div v-if="item.type == 1">
                        {{ $t("loginToDashboard") }}
                      </div>
                      <div v-if="item.type == 2">{{ $t("loginFailure") }}</div>
                      <div v-if="item.type == 3">
                        {{ $t("passwordChangedOnDashboard") }}
                      </div>
                      <div v-if="item.type == 4">
                        {{ $t("createdANewPasswordViaEmail") }}
                      </div>
                    </td>
                    <td>{{ item.systime }}</td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>

            <!-- 
  <button @click="crop">
	Crop
	</button> 
  -->
            <!-- 
  <div style="margin-top:50px">
  <img :src="image"></div>
  Son hatalı girişler falan -->
          </v-card>
          <v-card
            v-if="cropprocess"
            class="pa-2"
            outlined
            tile
            :loading="imageuploading"
          >
            <v-card-title style="display: flex; justify-content: space-between"
              >{{ $t("cropYourAvatar") }}
              <div>
                <v-btn @click="crop" :disabled="imageuploading">
                  {{ $t("cropAndUpdateAvatar") }}
                </v-btn>
              </div>
            </v-card-title>
            <div>
              <div>
                <cropper
                  :src="img"
                  :stencil-props="{
                    previewClass: 'circle-cropper__preview',
                  }"
                  class="circle-cropper"
                  stencil-component="circle-stencil"
                  ref="cropper"
                />
              </div>
            </div>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <!-- 
    Profile Page user.profile_photo_path - updatePhotoPreview - photoPreview -
    Select A New Photo - Delete Photo - Errors about photo name Error Name
    email. kısmı Your email address is unverified. Click here to re-send the
    verification email (sendEmailVerification) A new verification link has been
    sent to your email address. -->

    <!-- 2. sıra -->
    <!-- Current Password New Password Confirm Password -->

    <!-- 3. Two Factor Auth -->
    <!-- Two Factor Authentication Add additional security to your account using two
    factor authentication. -->
  </div>
</template>
<script>
import { CircleStencil, Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";
export default {
  name: "Profile",
  components: {
    Cropper,
  },
  data() {
    return {
      lang: {
        timezone: this.$i18n.t("timezone"),
        name: this.$i18n.t("name"),
        email: this.$i18n.t("email"),
      },
      items: [
        {
          text: "Dashboard",
          disabled: false,
          to: "/",
        },
        {
          text: "Profile",
          disabled: true,
          to: "/profile",
        },
      ],
      profileupdating: false,
      imageuploading: false,
      accountactivitiesloading: false,
      cropprocess: false,
      passwordupdating: false,
      changepassword: false,
      accountactivities: [],
      hover: true,
      img: "",
      image: "",
      loading: false,
      form: {
        currentpassword: null,
        newpassword: null,
        newpasswordconfirm: null,
      },
      showAvatarPicker: false,
      hasalert: false,
      alert: {
        type: "",
        text: "",
      },
      file: "",
    };
  },
  computed: {
    user: {
      get() {
        return this.$store.state.user;
      },
      set(value) {
        this.$store.commit("SET_USER", value);
      },
    },
    market: {
      get() {
        return this.$store.state.market;
      },
      set(value) {
        this.$store.commit("SET_MARKET", value);
      },
    },
  },
  methods: {
    handleFileUpload(event) {
      this.imageuploading = true;
      this.cropprocess = true;
      this.file = event.target.files[0];
      let formData = new FormData();
      formData.append("file", this.file);
      axios
        .post("/api/uploadsinglefile", formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.img = response.data;
          this.imageuploading = false;
        });
    },
    updatePassword() {
      this.passwordupdating = true;
      axios
        .post("/api/changeuserpassword", {
          currentpassword: this.form.currentpassword,
          newpassword: this.form.newpassword,
          newpasswordconfirm: this.form.newpasswordconfirm,
        })
        .then((response) => {
          this.passwordupdating = false;
          if (response.data.status == 3) {
            this.alert.type = "error";
            this.alert.text = this.$i18n.t("currentPasswordEnteredIncorrectly");
            this.hasalert = true;
          } else if (response.data.status == 2) {
            this.alert.type = "warning";
            this.alert.text = this.$i18n.t("newPasswordsDoNotMatch");
            this.hasalert = true;
          } else if (response.data.status == 1) {
            this.alert.type = "success";
            this.alert.text = this.$i18n.t("yourPasswordChangedSuccessfully");
            this.hasalert = true;
            this.changepassword = false;
            this.sendnotification(
              "standard",
              "success",
              this.$i18n.t("successfull"),
              this.$i18n.t("yourPasswordChangedSuccessfully"),
              10000
            );
          } else {
          }
        });
    },
    openAvatarUpload() {
      this.$refs.avatarfile.click();
    },

    // cropprocess
    change({ coordinates, canvas }) {},
    crop() {
      const { coordinates, canvas } = this.$refs.cropper.getResult();
      this.coordinates = coordinates;
      this.image = canvas.toDataURL();
      this.updateAvatar();
    },
    sendnotification(group, type, title, text, duration) {
      this.$notify({
        group: group,
        type: type,
        title: title,
        text: text,
        duration: duration,
      });
    },

    updateAvatar() {
      this.cropprocess = false;
      this.profileupdating = true;

      // let formData = new FormData();
      // formData.append('image', this.image);
      axios
        .post("/datafromapi/uploadavatar", {
          image: this.image,
        })
        .then((response) => {
          this.user.avatar = response.data;
          this.img = "";
          this.image = "";
          this.profileupdating = false;

          this.sendnotification(
            "standard",
            "success",
            this.$i18n.t("successfull"),
            this.$i18n.t("yourProfilePhotoHasBeenSuccessfullyChanged"),
            10000
          );
        });
    },
  },
};
</script>
<style lang="css">
.circle-cropper {
  width: 100%;
  background: #222;
  height: 500px;
}
.circle-cropper .__preview {
  border: solid 1px rgba(white, 0.15);
}
.avatarimg {
}
.avatararea {
  width: fit-content;
  padding: 35px;
  margin: auto;
  position: relative;
  margin-bottom: 50px;
}
.changeavatarhover {
  position: absolute;
  cursor: pointer;
  width: 100%;
  height: 70px;
  bottom: 0;
  background-color: rgba(219, 231, 219, 0.63);
}
.avataruploaddiv {
  margin: auto;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
}
.market_line {
  display: flex;
  padding: 15px 0 15px 0;
  border-bottom: 1px solid lightgray;
}
.market_line b {
  padding-right: 10px;
}
.prflbtn {
  margin: 18px auto 0;
  display: flex;
  justify-content: center;
}
.customcardtext {
  min-height: 677px;
}
.oneline {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
