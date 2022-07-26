
// $(function() {
    // $('#table').DataTable();
    // supprission d'une factures 
    $('body').on('click', '.deleteBtn', function(e){
        e.preventDefault(); 
        Swal.fire({
            title: 'Est vous sur de supprimer la facture N°' + this.dataset.id,
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "POST",
                    url: "process.php",
                    data: {deleteId: this.dataset.id},
                    success: function(response){
                          Swal.fire(
                            'Deleted!',
                            'Your Bill has been deleted.',
                            'success'
                          )
                              getBills();
                            
                          }
                        })   
            }
                })
          })
    // })
    //  recuperation des factures
    
    function getBills(){
        $.ajax({
            method: "POST",
            url: "process.php",
            data: {action: 'READ'},
            success: function(response){
                $('#order-table').html(response)
                $('#table').DataTable()
          }
        })
    }
    
      getBills();
    
    // crée une facture

    $('#create').on('click',function(e){
      
        let formOrder = $('#formOrder');
        if(formOrder[0].checkValidity()){
            e.preventDefault();
            $.ajax({
                method: "POST",
                url: "process.php",
                data: formOrder.serialize() + "&action=CREATE",
                success: function(response){
                  console.log(response)
                     $('#creatModal').modal('hide');
                     getBills();
                     Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Success',
                      }),
                      formOrder[0].reset();
              }
              })
        }else{
            console.log("problem validity form")
            formOrder[0].reset();
        }
 
        });
       
    // Update factures

    $('body').on('click', '.editBtn', function(e){
      e.preventDefault();
      $.ajax({
        method: "POST",
        url: "process.php",
        data: {UpdateId: this.dataset.id},
        success: function(response){
           let BillInfo = JSON.parse(response);
           $('#id_Bill').val(BillInfo[0].id)
           $('#customerUpdate').val(BillInfo[0].customer)
           $('#cashierUpdate').val(BillInfo[0].cashier)
           $('#amountUpdate').val(BillInfo[0].amount)
           $('#receivedUpdate').val(BillInfo[0].received)
           $('#stateUpdate').val(BillInfo[0].state)

      }
    })

    })


    $('#update').on('click',function(e){
      
      let formUpdateOrder = $('#formUpdateOrder');
      if(formUpdateOrder[0].checkValidity()){
          e.preventDefault();
          $.ajax({
              method: "POST",
              url: "process.php",
              data: formUpdateOrder.serialize() + "&action=UPDATE",
              success: function(response){
                console.log(response)

                   $('#updateModal').modal('hide');
                   getBills();
                   Swal.fire({
                      position: 'center',
                      icon: 'success',
                      title: 'success',
                    }),
                    formUpdateOrder[0].reset();
            }
            })
      }else{
          console.log("problem validity form")
          formUpdateOrder[0].reset();
      }

      });

      // info sur une facture

      $('body').on('click', '.infoBtn', function(e){
        e.preventDefault();
        $.ajax({
              method: "POST",
              url: "process.php",
              data: {readId: this.dataset.id},
              success: function(response){
                console.log(response)
                let infoBill = JSON.parse(response);
                Swal.fire({
                  title: '<strong style="color:blue;">Fcartures # <u>'+ infoBill[0].id+'</u></strong>',
                  icon: 'info',
                  html:
                 '<ul style="list-style: none; margin-left:0; padding:0;">'
                 +'<li> Nom du client :'+infoBill[0].customer+'</li>'
                 +'<li> Montant facture :'+infoBill[0].amount+'</li>'
                 +'<li> Montant perçu :'+infoBill[0].received+'</li>'
                 +'<li> Etat facture :'+infoBill[0].state+'</li>'
                 +'<li>etablie par : '+infoBill[0].cashier+'</li>'
                 +'</ul>',
                  showCloseButton: true,
                  
                  focusConfirm: false,
                  confirmButtonText:
                    '<i class="fa fa-thumbs-up"></i> Super!',
                  confirmButtonAriaLabel: 'Thumbs up, Super!',
                })
              }
        })
      })