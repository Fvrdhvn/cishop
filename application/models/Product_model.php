<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends MY_Model
{

    // protected $perPage = 5;

    public function getDefaultValues()
    {
        return [
            'id_category'   => '',
            'slug'          => '',
            'title'         => '',
            'description'   => '',
            'price'         => '',
            'is_available'  => 1,
            'image'         => '',
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field'     => 'id_category',
                'label'     => 'Kategori',
                'rules'     => 'required'
            ],
            [
                'field'     => 'slug',
                'label'     => 'slug',
                'rules'     => 'trim|required|callback_unique_slug'
            ],
            [
                'field'     => 'description',
                'label'     => 'Deskripsi',
                'rules'     => 'trim|required'
            ],
            [
                'field'     => 'price',
                'label'     => 'Harga',
                'rules'     => 'trim|required|numeric'
            ],
            [
                'field'     => 'is_available',
                'label'     => 'Ketersediaan',
                'rules'     => 'required'
            ],
        ];

        return $validationRules;
    }

    public function uploadImage($fieldName, $fileName)
    {
        // Pastikan direktori upload sudah ada
        if (!is_dir(FCPATH . 'images/product')) {
            mkdir(FCPATH . 'images/product', 0777, TRUE); // Membuat direktori jika belum ada
        }

        $config = [
            'upload_path'       => FCPATH . 'images/product', // Gunakan jalur absolut
            'file_name'         => $fileName, // Gunakan nama file yang benar
            'allowed_types'     => 'jpg|gif|png|jpeg|JPG|PNG',
            'max_size'          => 1024, // 1MB
            'max_width'         => 0,
            'max_height'        => 0,
            'overwrite'         => true,
            'file_ext_tolower'  => true,
        ];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($fieldName)) {
            return $this->upload->data(); // Kembalikan informasi file yang diupload
        } else {
            return false; // Upload gagal
        }
    }


    public function deleteImage($fileName)
    {
        if (file_exists("./images/product/$fileName")) {
            unlink("./images/product/$fileName");
        }
    }
}

/* End of file Product_model.php */
