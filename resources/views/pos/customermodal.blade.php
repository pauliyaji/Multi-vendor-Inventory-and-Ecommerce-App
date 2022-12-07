<!-- Modal -->
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                    <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Details</label>
                        <div class="col-sm-12">
                            <textarea id="detail" name="detail" required="" placeholder="Enter Details" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



//////my store

<tr>
    <td><input type="text" name="prod_name" id="prod_name"></td>
    <td width="15%" class="text-center">500</td>
    <td width="15%">
        <div class="input-group">
            <button type="button" class="input-group-text">-</button>
            <div class="form-control text-center">2</div>
            <button type="button" class="input-group-text">+</button>
        </div>
    </td>
    <td width="15%" class="text-center">500</td>
    <td width="15%" class="text-center">100</td>
    <td width="10%">
        <button type="button" class="btn btn-danger btn-sm">Remove</button>
    </td>
</tr>
