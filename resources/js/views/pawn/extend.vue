<template>
    <div>
        <div class="page-title page-title--alt">
            <div class="row">
                <div class="col-xl-7 d-block d-xl-flex align-items-center">
                    <div class="pr-0 pr-xl-4 mb-4 mb-xl-0">
                        <div
                            class="d-70 mx-auto rounded font-size-xxl bg-white text-center shadow-sm"
                            >
                            <font-awesome-icon
                                icon="clock"
                                class="text-primary mt-1"
                            />
                        </div>
                    </div>
                    <div>
                        <h5 class="display-4 mt-1 mb-2 font-weight-bold">ต่ออายุดอกเบี้ย</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-box">
                        <div class="card-header">
                            <h5 class="my-3">ข้อมูลสินค้าจำนำ</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                    <label class="col-md-12" for="inputCustomerInfo">ค้นหาจากฐานข้อมูลลูกค้า</label>
                                </div>
                                <div class="form-row">
                                    <b-form-group class="col-sm-10" > 
                                        <b-form-input
                                            name="customerInfo"
                                            type="text"
                                            id="inputCustomerInfo"
                                            placeholder="ระบุชื่อ, นามสกุล, เลขบัตรประจำตัวประชาชน หรือเลขบัตรจำนำ"
                                        ></b-form-input>
                                    </b-form-group>
                                    <b-form-group class="col-sm-2"> 
                                        <b-button variant="primary">ค้นหา</b-button>
                                    </b-form-group>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-xl-12 d-block">
                                        <h4 v-show="true" style="text-align:center" class="text-black-50">กรุณากรอกข้อมูลเพื่อทำการค้นหา</h4>
                                        <h4 v-show="false" style="text-align:center" class="text-black-50">ไม่พบข้อมูลที่ต้องการ กรุณาตรวจสอบความถูกต้องอีกครั้ง</h4>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    
}
</script>

