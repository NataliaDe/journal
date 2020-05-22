<div class="modal fade" id="modal_is_exclude_statistics" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title ff-l" id="myModalLabel">Исключить выезды из статистики</h4>

                <button class="close danger" type="button" data-dismiss="modal" style="font-weight: bolder;    margin-top: -25px;">×</button>

            </div>

            <div class="modal-body">

                <p>Все выезды, отмеченнные &nbsp;&nbsp;&nbsp;&nbsp;
                     <span class="options">
                         <label style="display: inline;">
                            <input type="checkbox" checked="" disabled="" >
                            <img />
                        </label>
                    </span>
                    , будут исключены из статистики.</p>
                <p>Информация в автоматическом режиме будет направлена администратору для планирования запуска пересчета статистики с
                учетом изменений.</p>
                <p>Продолжить?</p>

            </div>
            <div class="modal-footer">

                <a href="#" id="btn_exclude_statistics" onclick="excludeStatistics();" ><button type="button" class="btn btn-success" >Да</button></a>
                <button  type="button" class="btn btn-secondary" data-dismiss="modal" >Отмена</button>
            </div>
        </div>
    </div>
</div>
