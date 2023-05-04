<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" action="{{ route('papelSheetExam.update', $papelSheetExam->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $papelSheetExam->id }}" name="id">
        <div class="form-group">
            <div class="row">
                <div class="col-md-2">
                    <label for="degree" class="form-control-label">الدرجة</label>
                    <input type="number" class="form-control" name="degree" value="{{ $papelSheetExam->degree }}" style="text-align: center" required>
                    </Select>
                </div>
                <div class="col-md-4" style="    position: absolute;
    right: 500px;">
                    <label for="date_exam" class="form-control-label">وقت الامتحان</label>
                    <input type="date" class="form-control" name="date_exam" value="{{ $papelSheetExam->date_exam }}" style="text-align: center" required>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_ar" class="form-control-label">الاسم بالعربية</label>
                    <input type="text" class="form-control" name="name_ar" value="{{ $papelSheetExam->name_ar }}" style="text-align: center" required>
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الاسم بالانجليزية</label>
                    <input type="text" class="form-control" value="{{ $papelSheetExam->name_en }}" name="name_en" style="text-align: center" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="note" class="form-control-label">تيرم</label>
                    <Select name="term_id" class="form-control" required>
                        <option selected disabled style="text-align: center">اختر تيرم</option>
                        @foreach($data['terms'] as $term)
                            <option value="{{ $term->id }}"
                                    {{ $papelSheetExam->term_id == $term->id ? 'selected' : '' }}
                                    style="text-align: center">{{ $term->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-control-label">الصف</label>
                    <Select name="season_id" class="form-control" required>
                        <option selected disabled style="text-align: center">اختر صف</option>
                        @foreach($data['seasons'] as $season)
                            <option value="{{ $season->id }}"
                                    {{ $papelSheetExam->season_id == $season->id ? 'selected' : '' }}
                                    style="text-align: center">{{ $season->name_ar }}</option>
                        @endforeach
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">من</label>
                    <input type="date" class="form-control" value="{{ $papelSheetExam->from }}" name="from" style="text-align: center" required>
                </div>
                <div class="col-md-6">
                    <label for="name_en" class="form-control-label">الى</label>
                    <input type="date" class="form-control" value="{{ $papelSheetExam->to }}" name="to" style="text-align: center" required>
                    </Select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="name_en" class="form-control-label">الوصف</label>
                    <textarea class="form-control" name="description" rows="8">{{ $papelSheetExam->description }}</textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            <button type="submit" class="btn btn-success" id="updateButton">تحديث</button>
        </div>
    </form>
</div>
<script>

</script>
