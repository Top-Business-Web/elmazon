<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" action="{{ route('discount_coupons.store') }}">
        @csrf
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="coupon" class="form-control-label">كوبون</label>
                    <input type="text" class="form-control" name="coupon" required>
                </div>
                <div class="col-md-6">
                    <label for="discount_type" class="form-control-label">نوع الخصم</label>
                    <select name="discount_type" class="form-control">
                        <option value="per">بالقيمة المئوية</option>
                        <option value="value">بالجنيه المصري</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="discount_amount" class="form-control-label">كمية الخصم</label>
                    <input type="number" class="form-control" name="discount_amount" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="valid_from" class="form-control-label">صالح من تاريخ</label>
                    <input type="date" class="form-control" name="valid_from" required>
                </div>
                <div class="col-md-6">
                    <label for="valid_to" class="form-control-label">صالح  لل</label>
                    <input type="date" class="form-control" name="valid_to" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="is_enabled" class="form-control-label">متاح</label>
                    <select name="is_enabled" class="form-control">
                        <option value="1">نعم</option>
                        <option value="0">لا</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="total_usage" class="form-control-label">مجموع الاستخدام</label>
                    <input type="number" class="form-control" name="total_usage" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-primary" id="addButton">اضافة</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>
