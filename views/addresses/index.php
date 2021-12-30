<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/10/2020
 * Time: 2:08 PM
 */






/* @var $this yii\web\View */

$this->title = 'Supplier Additional Addresses';
?>


    <!--THE STEPS THING--->

    <div class="row">
        <div class="col-md-12">
            <?= $this->render('..\company-profile\_steps', ['model'=>$Applicant]) ?>
        </div>
    </div>

    <!--END THE STEPS THING--->

    
    <?php if($Applicant->Status == 'New'): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <?= \yii\helpers\Html::a('Add',['create','Key'=> $Applicant->Key],['class' => 'add btn btn-info btn-md mr-2 ']) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <div class="card-body">
        <table class="table table-bordered dt-responsive table-hover" id="leaves">
        </table>
    </div>

<input type="hidden" name="absolute" value="<?= Yii::$app->recruitment->absoluteUrl() ?>">
<input type="hidden" name="DocNum" value="<?=$Applicant->No ?>">





 <!--My Bs Modal template  --->

 <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Supplier Profile</h4>
                </div>
                <div class="modal-body">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading</span>
                            </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>

            </div>
        </div>
    </div>

<?php

$script = <<<JS

    $(function(){
        
        var absolute = $('input[name=absolute]').val();
        var Docnum = $('input[name=DocNum]').val();

         /*Data Tables*/
         
        // $.fn.dataTable.ext.errMode = 'throw';

          $('#leaves').DataTable({
           
            //serverSide: true,  
            ajax: absolute+'addresses/list',
            paging: true,
            responsive:true,
            columns: [
                { title: '#', data: 'index'},
                { title: 'Address' ,data: 'Address'},
                { title: 'Post Code' ,data: 'Post_Code'},
                { title: 'City' ,data: 'City'},
                { title: 'Country Code' ,data: 'Country_Code'},  
                { title: 'Telephone 0No' ,data: 'Telephone_No'},  
                { title: 'E-mail' ,data: 'E_mail'},  
                { title: 'Actions' ,data: 'action'},
                
            ] ,                              
           language: {
                "zeroRecords": "No Bank Addresses to Show.."
            },
            
            order : [[ 0, "asc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#leaves').DataTable();
    //   table.columns([0]).visible(false);
    
    /*End Data tables*/
            $('#leaves').on('click','.update', function(e){
                 e.preventDefault();
                var url = $(this).attr('href');
                console.log('clicking...');
                $('.modal').modal('show')
                                .find('.modal-body')
                                .load(url); 
    
            });
            
            
           //Add a record
        
         $('.add').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
    
         });

         $('#leaves').on('click','.delete',function(e){
         e.preventDefault();
           var secondThought = confirm("Are you sure you want to delete this record ?");
           if(!secondThought){//if user says no, kill code execution
                return;
           }
           
         var url = $(this).attr('href');
         $.get(url).done(function(msg){
             $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
         },'json');
     });
        
        /*Handle dismissal eveent of modal */
        $('.modal').on('hidden.bs.modal',function(){
            var reld = location.reload(true);
            setTimeout(reld,1000);
        });
    });
        
JS;

$this->registerJs($script);








