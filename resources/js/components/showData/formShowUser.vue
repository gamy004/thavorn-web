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
          <textarea name="note" id="textarea-note" ref="textarea_note" class="form-control" cols="30" rows="10" v-model="note" v-on:keyup.enter="clicksave"></textarea>

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
      note: ""
    }
  },
  props:{
    data: {
        type: Array,
        defult: []
    },
  },
  methods: {
    openNote(id) {
      this.noteId = id
      this.$bvModal.show('notemodal')
      console.log(this.$refs);
      setTimeout(() => { this.$refs.textarea_note.focus(); }, 100);
      
    },
    async clicksave() {
      let id = this.noteId
      let text = this.note
      console.log('clicksave : ',id,text);
      try {
        let data = {
          note : text
        }
        await window.api.patch(`users/${id}`, data);
        console.log('Update : ',data);
        this.clearData()
        this.$bvModal.hide('notemodal')
        this.$refs.error.setShowPop(1,'Data has been updated.')
      }catch(error) {
        console.log(error);
        this.$bvModal.hide('notemodal')
        this.$refs.error.setShowPop(1,'ERROR')
      }
    },
    cancel() {
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

table {
    border-collapse: collapse;
    width: 100%;
    text-align: center;
    border-radius: calc(1px + 0.2vw);
    font-size: calc(9px + 0.5vw);
}

table td, table th {
    padding: 1vw;
}

table tr:nth-child(even){background-color: #f2f2f2;}
table tr:hover {background-color: #ddd;}
table th {
    font-weight: 400;
}
.activeClass{
    background-color: rgb(255, 156, 156) !important;
    &:hover{
        background-color: rgb(255, 125, 125) !important;
    }
}
</style>
