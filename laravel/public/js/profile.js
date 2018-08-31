var getRegencies = function(province_id) {
    $.get('{{ url("information") }}/create/ajax-regencies?province_id=' + province_id, function(data) {
        $('#regencies').html(data);
        regency_id = $('#regencies').val();
        getDistricts(regency_id);
        $('#regencies').selectpicker('refresh');
    });
}

var getDistricts = function(regency_id) {
    $.get('{{ url("information") }}/create/ajax-districts?regency_id=' + regency_id, function(data) {
        $('#districts').html(data);
        district_id = $('#districts').val();
        getVillages(district_id);
        $('#districts').selectpicker('refresh');
    });
}

var getVillages = function(district_id) {
    $.get('{{ url("information") }}/create/ajax-villages?district_id=' + district_id, function(data) {
        $('#villages').html(data);
        $('#villages').selectpicker('refresh');
    });
}

function isImage(ext) {
    switch (ext.toLowerCase()) {
    case 'jpg':
    case 'gif':
    case 'bmp':
    case 'png':
        //etc
        return true;
    }
    return false;
}

function removePhoto() {
    swal({
        title: "Yakin?",
        text: "Fotonya mau dihapus?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, hapus aja!",
        closeOnConfirm: false
    }, function () {
        $.ajax({
            url: 'profile/remove_photo',
            data: {_token: '{{ csrf_token() }}'},
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                swal("Berhasil!", data.message, "success");
                $('#profile_photo').attr('src', "{{ asset('uploads/images/users') }}/"+data.photo);
                $('#fit_profile_photo').attr('src', "{{ asset('uploads/images/users') }}/fit_"+data.photo);
            },
            error: function(data) {
                swal("Gagal!", data, "error");
            }
        });
    });
    $('#photo-update').modal('hide');
}

function removePoster() {
    swal({
        title: "Yakin?",
        text: "Posternya mau dihapus?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, hapus aja!",
        closeOnConfirm: false
    }, function () {
        $.ajax({
            url: 'profile/remove_poster',
            data: {_token: '{{ csrf_token() }}'},
            type: 'POST',
            success: function(data) {
                swal("Berhasil!", data, "success");
                $('#poster_image').attr('src', "{{ asset('uploads/images/posters') }}/poster.jpg");
                $('#fit_poster_image').css('background', "url('{{ asset('uploads/images/posters') }}/fit_poster.jpg");
                $('#fit_poster_image').css('background-size', 'cover');
            },
            error: function(data) {
                swal("Gagal!", data, "error");
                console.log(data);
            }
        });
    });
    $('#poster-update').modal('hide');
}

function remove_social(sid) {
    swal({
        title: "Yakin?",
        text: "Mau hapus media sosial ini?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, hapus aja!",
        closeOnConfirm: false
    }, function () {
        $.ajax({
            url: 'profile/remove_social',
            data: {_token: '{{ csrf_token() }}', id:sid},
            type: 'POST',
            success: function(data) {
                swal("Berhasil!", data, "success");
                $('#social-table').find('[data-id="'+sid+'"]').remove();
            },
            error: function(data) {
                swal("Gagal!", data, "error");
                console.log(data);
            }
        });
    });
    $('#poster-update').modal('hide');
}

function reset_social() {
    $('#social-id').val('');
    $('#social-name').val('');
    $('#social-icon').val('');
    $('#social-link').val('');
    $('#display-icon').html('<span class="socicon-internet socicon-icon" style="background-color: black;"></span>');
}

function edit_social(sid) {
    $.ajax({
        type: "POST",
        data: {_token: '{{ csrf_token() }}', id:sid},
        url: "{{ url('/profile/get_social') }}",
        dataType: "json",
        success: function(data) {
            console.log(data);
            $('#social-id').val(sid);
            $('#social-name').val(data.name);
            $('#social-icon').val(data.icon);
            $('#display-icon').html('<span class="socicon-icon '+data.icon+'" style="background-color: '+data.color+'"></span>');
            $('#social-link').val(data.link);
            $('#social-form').modal('show');
        },
        error: function(data) {
            showAlert('Error: ' + data, 'bg-red');
        }
    })
    $('#social-form').modal('show');
}

function save_social() {
    var id = $('#social-id').val();
    var name = $('#social-name').val();
    var icon = $('#social-icon').val();
    var color = $('#display-icon').find('span.socicon-icon').css('background-color');
    var link = $('#social-link').val();
    $('#save').attr('disabled', 'disabled');
    if (name == '' || icon == '' || link == '') {
        showAlert('Isi semua datanya dong.. Ada yang belum diisi tuh!!', 'bg-deep-orange');
        setInterval(function() {
            $('#save').removeAttr('disabled');
        }, 2000);
    } else {
        if (id > 0) {
            $.ajax({
                type: "POST",
                data: {_token: '{{ csrf_token() }}', id:id, name:name, icon:icon, link:link, color:color},
                url: "{{ url('/profile/update_social') }}",
                success: function(data) {
                    showAlert(data, 'bg-blue');
                    var td = '<td width="45"><a href="'+link+'" target="_blank"><span class="'+icon+' socicon-icon" style="background-color: '+color+';"></span></a></td><td><a href="'+link+'" target="_blank">'+name+'</a></td><td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_social('+id+');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_social('+id+');"><i class="fa fa-trash"></i></a></td>';
                    $('#social-table').find('[data-id="'+id+'"]').html(td);
                    $('#social-form').modal('hide');
                },
                error: function(data) {
                    showAlert('Error: ' + data, 'bg-red');
                }
            });
        } else {
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {_token: '{{ csrf_token() }}', name:name, icon:icon, link:link, color:color},
                url: "{{ url('/profile/add_social') }}",
                success: function(data) {
                    showAlert(data.message, 'bg-blue');
                    var tr = '<tr data-id="'+data.id+'"><td width="45"><a href="'+data.link+'" target="_blank"><span class="'+data.icon+' socicon-icon" style="background-color: '+data.color+';"></span></a></td><td><a href="'+data.link+'" target="_blank">'+data.name+'</a></td><td width="50"><a href="javascript:void(0);" title="edit" onclick="edit_social('+data.id+');"><i class="fa fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" title="hapus" onclick="remove_social('+data.id+');"><i class="fa fa-trash"></i></a></td></tr>';
                    $('#social-table').append(tr);
                    $('#social-form').modal('hide');
                },
                error: function(data) {
                    console.log(data);
                    showAlert('Error: ' + data, 'bg-red');
                }
            });
        }
    }
}

function updateData(column, newValue) {
    $.ajax({
        url: 'profile/update',
        data: {_token: '{{ csrf_token() }}', column: column, value: newValue},
        type: 'POST',
        success: function(data) {
            showAlert(data, 'bg-blue');
            $('#p-'+column).html(newValue);
        },
        error: function(data) {
            showAlert('Error: Data gagal diupdate', 'bg-red');
        }
    });
}

function changeJK() {
    var sex = $('#sex').val();
    if (sex == 'm') {
        var sex_val = 'Laki-laki';
    } else {
        var sex_val = 'Perempuan';
    }
    swal({
        title: "Yakin?",
        text: "Mau ganti Jenis Kelamin?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, ganti aja!",
        closeOnConfirm: false
    }, function () {
        window.onkeydown = null;
        window.onfocus = null;
        updateData('sex', sex);
        swal("Berhasil!", "Data Jenis Kelamin berhasil diganti.", "success");
        $('#sex-column').html(sex_val);
        $('#sex-edit').modal('hide');
    });
}

function changeBirth() {
    var birthplace = $('#birthplace').val();
    var birthdate = moment($('#birthdate').val(), 'dddd DD MMMM YYYY').format('YYYY-MM-DD');
    var birth_val = birthplace+", "+$('#birthdate').val();
    swal({
        title: "Yakin?",
        text: "Mau ganti Tempat, Tanggal Lahir?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, ganti aja!",
        closeOnConfirm: false
    }, function () {
        window.onkeydown = null;
        window.onfocus = null;
        updateData('birthplace', birthplace);
        updateData('birthdate', birthdate);
        swal("Berhasil!", "Data Tempat, Tanggal Lahir berhasil diganti.", "success");
        $('#birth-column').html(birth_val);
        $('#birth-edit').modal('hide');
    });
}

function changeAddress() {
    var village_id = $('#villages').val();
    var address = $('#address').val();
    var postcode = $('#postcode').val();
    swal({
        title: "Yakin?",
        text: "Data Alamatnya sudah bener?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, sudah!",
        closeOnConfirm: false
    }, function () {
        window.onkeydown = null;
        window.onfocus = null;
        if (village_id && address && postcode) {
            if (postcode.length == 5) {
                updateData('village_id', village_id);
                updateData('address', address);
                updateData('postcode', postcode);
                $.ajax({
                    url: 'profile/address',
                    data: {_token: '{{ csrf_token() }}', village_id: village_id},
                    type: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        swal("Berhasil!", "Data Alamat berhasil diganti.", "success");
                        $('#p-address').html(data.paddress);
                        $('#address-column').html(address+' '+data.address+' '+postcode);
                        $('#address-edit').modal('hide');
                    }
                });
            } else {
                swal("Gagal!", "Data Kode POS harus 5 digit.", "error");
            }
        } else {
            swal("Isi Dong!", "Datanya nggak diisi semua tuh!", "error");
        }
    });
}

function resetFormPassword() {
    $('#password-form')[0].reset();
    $('#password-form').find('div.form-line').removeClass('focused');
}

function changePassword() {
    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var confirm_password = $('#confirm_password').val();
    swal({
        title: "Yakin?",
        text: "Mau ganti Password?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, ganti aja!",
        closeOnConfirm: false
    }, function () {
        window.onkeydown = null;
        window.onfocus = null;
        if (old_password && new_password && confirm_password) {
            if (new_password === confirm_password) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/profile/password') }}",
                    dataType: 'json',
                    data: {_token: '{{ csrf_token() }}', new_password:new_password, old_password:old_password},
                    success: function(data) {
                        if (data.success) {
                            swal("Berhasil!", data.message, "success");
                            $('#password-edit').modal('hide');
                            resetFormPassword();
                        } else {
                            swal("Yaaahh!", data.message, "error");
                            $('#old_password').val('');
                            window.setTimeout(function () { 
                                $('#old_password').focus(); 
                            }, 0);
                        }
                    },
                    error: function(data) {
                        swal("Error!", data, "error");
                        console.log(data);
                    }
                });
            } else {
                swal("Nggak sama!", "Password Baru gak sama!\nCek lagi, bisi salah!", "error");
            }
        } else {
            swal("Isi Dong!", "Datanya nggak diisi semua tuh!", "error");
        }
    });
}

$(function () {
    //Textare auto growth
    autosize($('textarea.auto-growth'));

    $('.iconnya').on('click', function() {
        var icon = $(this).find('span.icon-name').html();
        var background = $(this).find('span.socicon-icon').css('background-color');
        $('#social-icon').val(icon);
        $('#display-icon').html('<span class="'+icon+' socicon-icon" style="background-color: '+background+'"></span>');
        $('#socicon').modal('hide');
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        format: 'dddd DD MMMM YYYY',
        clearButton: true,
        weekStart: 1,
        time: false,
        lang: 'id-ID'
    });

    $('#profile-table').editableTableWidget();

    $('table td').on('change', function(evt, newValue) {
        var column = $(this).data('column');
        var required = ['name', 'fullname', 'email', 'phone', 'year_out', 'year_in'];
        newValue = newValue.trim();
        if (newValue) {
            var years = ['year_in', 'year_out'];
            var currentYear = (new Date()).getFullYear();
            var year = 1994;
            if (years.indexOf(column) > -1) {
                if (newValue >= year && newValue <= currentYear) {
                    updateData(column, newValue);
                } else {
                    swal('Error', 'Data harus rentang dari tahun '+year+' dan tahun '+currentYear, 'error');
                    return false;
                }
            } else if (column == 'phone') {
                var numbers = /^[0-9]+$/;
                if (newValue.match(numbers)) {
                    updateData(column, newValue);
                } else {
                    swal('Error', 'Format data tidak sesuai!\ncontoh: 089658590616', 'error');
                    return false;
                }
            } else if (column == 'email') {
                if (isEmail(newValue)) {
                    updateData(column, newValue);
                } else {
                    swal('Error', 'Format data tidak sesuai!\ncontoh: saklu07@gmail.com', 'error');
                    return false;
                }
            } else {
                updateData(column, newValue);
            }
        } else {
            if (required.indexOf(column) > -1) {
                swal('Error', 'Data nggak boleh kosong!', 'error');
                return false;
            } else {
                updateData(column, newValue);
            }
        }
    });

    $('#photo').on('change', function() {
        filename = $('#photo').val();
        var parts = filename.split('.');
        var ext = parts[parts.length - 1];
        if (!isImage(ext)) {
            alert('bukan image');
        } else {
            var id = $('#uploadphoto').val();
            var photo = $('#photo')[0].files[0];
            var form = new FormData();
            form.append('id', id);
            form.append('_token', '{{ csrf_token() }}');
            form.append('photo', photo);
            $.ajax({
                url: 'profile/photo',
                data: form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data) {
                    $('#profile_photo').attr('src', "{{ asset('uploads/images/users') }}/"+data.photo+"?"+new Date().getTime());
                    $('#fit_profile_photo').attr('src', "{{ asset('uploads/images/users') }}/fit_"+data.photo+"?"+new Date().getTime());
                    showAlert(data.message, 'bg-blue');
                },
                error: function(data) {
                    showAlert('Error: ' + data, 'bg-red');
                }
            });
        }
    });
    $('#poster').on('change', function() {
        filename = $('#poster').val();
        var parts = filename.split('.');
        var ext = parts[parts.length - 1];
        if (!isImage(ext)) {
            alert('bukan image');
        } else {
            var id = $('#uploadposter').val();
            var poster = $('#poster')[0].files[0];
            var form = new FormData();
            form.append('id', id);
            form.append('_token', '{{ csrf_token() }}');
            form.append('poster', poster);
            $.ajax({
                url: 'profile/poster',
                data: form,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data) {
                    $('#poster_image').attr('src', "{{ asset('uploads/images/posters') }}/"+data.poster+"?"+new Date().getTime());
                    $('#fit_poster_image').css('background', "url('{{ asset('uploads/images/posters') }}/fit_"+data.poster+"?"+new Date().getTime());
                    $('#fit_poster_image').css('background-size', 'cover');
                    showAlert(data.message, 'bg-blue');
                },
                error: function(data) {
                    showAlert('Error: ' + data, 'bg-red');
                }
            });
        }
    })
})