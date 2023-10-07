<div class="modal fade" id="endShiftModal" tabindex="-1" role="dialog" aria-labelledby="endShiftLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('logout')}}" method="get">
                   <h4>{{$user->cashier_sales->where('created_at','>',now()->subHours(12))->sum('total_amount')}} المبلغ النهائي هو </h4>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-primary">انهاء الوردية</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
