<?php

//memuat data dengan format option,dikhusukan utk form select
function getDropDownList($table, $columns)
{
    $CI = &get_instance();
    $query = $CI->db->select($columns)->from($table)->get();

    if ($query->num_rows() >= 1) {
        $option1    = ['' => '- Select -'];
        $option2    = array_column($query->result_array(), $columns[1], $columns[0]);
        $options    = $option1 + $option2;

        return $options;
    }

    return $options = ['' => '- Select -'];
}

//untuk memuat data kategori 
function getCategories()
{
    $CI     = &get_instance();
    $query  = $CI->db->get('category')->result();
    return $query;
}

//untuk menghitung jumlah suatu data dlm tabel cart
function getCart()
{
    $CI     = &get_instance();
    $userId = $CI->session->userdata('id');

    if ($userId) {
        $query = $CI->db->where('id_user', $userId)->count_all_result('cart');
        return $query;
    }

    return false;
}

//keamanan password
function hashEncrypt($input)
{
    $hash   = password_hash($input, PASSWORD_DEFAULT);
    return $hash;
}

function hashEncryptVerify($input, $hash)
{
    if (password_verify($input, $hash)) {
        return true;
    } else {
        return false;
    }
}
