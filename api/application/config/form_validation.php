<?php

$config = array(
                'addaccount' => array(
                                    array(
                                            'field' => 'email',
                                            'label' => 'Email',
                                            'rules' => 'trim|required|valid_email|is_unique[pt_accounts.accounts_email]'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'Password',
                                            'rules' => 'required|min_length[6]'
                                         ),
                                    array(
                                            'field' => 'country',
                                            'label' => 'Country',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'city',
                                            'label' => 'City',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'state',
                                            'label' => 'State',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'fname',
                                            'label' => 'First Name',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'lname',
                                            'label' => 'Last Name',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'address1',
                                            'label' => 'Address 1',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'address2',
                                            'label' => 'Address 2',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'mobile',
                                            'label' => 'Mobile',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'newssub',
                                            'label' => 'Subscribe',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'permissions[]',
                                            'label' => 'Permissions',
                                            'rules' => 'trim'
                                         )
                                    ),
                'updateaccount' => array(
                                    array(
                                            'field' => 'email',
                                            'label' => 'Email',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'country',
                                            'label' => 'Country',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'city',
                                            'label' => 'City',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'state',
                                            'label' => 'State',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'fname',
                                            'label' => 'First Name',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'lname',
                                            'label' => 'Last Name',
                                            'rules' => 'trim|required'
                                         ),
                                    array(
                                            'field' => 'address1',
                                            'label' => 'Address 1',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'address2',
                                            'label' => 'Address 2',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'mobile',
                                            'label' => 'Mobile',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'newssub',
                                            'label' => 'Subscribe',
                                            'rules' => 'trim'
                                         ),
                                    array(
                                            'field' => 'permissions[]',
                                            'label' => 'Permissions',
                                            'rules' => 'trim'
                                         )
                                    )
               );