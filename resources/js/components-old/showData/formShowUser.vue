<template>
  <div>
    <div class="h-flex-col-s-flex-row">
        <table>
            <tbody>
                <tr class="bg-primary text-white">
                    <th>เลขบัตรประชาชน</th>
                    <th>ชื่อ</th>
                    <th>นามสุกล</th>
                    <th>เลขโทรศัพท์</th>
                    <th>วันที่สร้าง</th>
                </tr>
                <tr v-for="(item, index) in data" :key="index" @click="openNote(item.id)">
                    <td>{{item.identity_card_id}}</td>
                    <td>{{item.first_name}}</td>
                    <td>{{item.last_name}}</td>
                    <td>{{item.phone_number}}</td>
                    <td>{{item.created_at}}</td>
                </tr>
            </tbody>
        </table>

        <b-modal v-show="noteId" id="notemodal" hide-header>
          <h4 class="mt-3 mb-4  d-flex justify-content-center">Add note</h4>
          <textarea v-show="activeAddNote" name="note" id="textarea-note" ref="textarea_note" class="form-control" cols="30" rows="10" v-model="note" v-on:keyup.enter="clicksave"></textarea>

          <template slot="modal-footer" class="modal-footer ml-3 mr-3">
            <button type="button" class="btn btn-success" @click="clicksave">
              <a class="ft-s-16">Save</a>
            </button>
            <button type="button" class="btn btn-secondary" @click="cancel">
              <a class="ft-s-16">Cancel</a>
            </button>
          </template>
        </b-modal>

        <error ref="error" />
    </div>
  </div>
</template>

<script>
import Vue from 'vue';
import error from '../popup/error.vue'

export default Vue.extend({
  name: 'usertable',
  components:{
    error
  },
  data() {
    return {
      noteId: null,
      note: "",
      activeAddNote: 0
    }
  },
  props:{
    data: {
        type: Array,
        defult: []
    },
  },
  methods: {
    async openNote(id) {
      this.noteId = id
      this.$bvModal.show('notemodal')
      console.log(this.$refs);
      let res = await window.api.get(`users/${id}`)
      this.note = res.data.users.note
      this.activeAddNote = 1
      setTimeout(() => { this.$refs.textarea_note.focus(); }, 100);
      
    },
    async clicksave() {
      let id = this.noteId
      let text = this.note
      console.log('clicksave : ',id,text);
      try {
        let user = {
          note : text
        }
        await window.api.patch(`users/${id}`, user);
        console.log('Update : ',user);
        this.clearData()
        this.$bvModal.hide('notemodal')
        this.activeAddNote = 0
        this.$refs.error.setShowPop(1,'Data has been updated.')
      }catch(error) {
        this.activeAddNote = 0
        console.log(error);
        this.$bvModal.hide('notemodal')
        this.$refs.error.setShowPop(1,'ERROR')
      }
    },
    cancel() {
      this.activeAddNote = 0
      this.$bvModal.hide('notemodal')
    },
    clearData() {
      this.noteId = null
      this.note = ""
    }
  },
  computed: {

  },
  watch: {

  },
  mounted() {

  },


});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.margin-cus{
    margin-top: 18px;
}
.flex-cus{
    justify-content: space-around;
}
.h-flex-row-s-flex-col{
  display: flex;
  flex-flow: row;
  @media(max-width: 991px){
    flex-flow:  column;
  }
}
.grow-1{
  display: flex;
  flex-grow: 1;
}
.border-cus{
    border: rgba(0,0,0,0.2) solid 1px;
}
.border-radius-cus{
    border-radius: 5px;
}
</style>
