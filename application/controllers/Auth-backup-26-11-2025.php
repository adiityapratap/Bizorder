<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property Ion_auth|Ion_auth_model $ion_auth        The ION Auth spark
 * @property CI_Form_validation      $form_validation The form validation library
 */
class Auth extends MY_Controller
{
	public $data = [];
	
	// PHP 8.2+ requires property declarations to avoid deprecation warnings
	public $auth_model;
	public $general_model;
	public $common_model;
	public $location_id;

	public function __construct()
	{
		parent::__construct();
	    $this->load->model('auth_model');
	    
	    $this->load->model('general_model');
	    $this->load->model('common_model');
		$this->load->library(['ion_auth']);
		$this->load->helper(['url', 'language']);
// 		$this->form_validation->set_error_delimiters($nthis->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->location_id = $this->session->userdata('location_id');
		$this->lang->load('auth');
	   $groups = $this->ion_auth->get_users_groups()->result();
       if ($this->ion_auth->logged_in() && empty($groups)) {
           $this->logout();
            $this->session->set_flashdata('message', 'Your role has been deleted by admin, please contact admin');
            redirect('auth/login', 'refresh');
        }
		
	
	}


	public function index()
	{
       
		if (!$this->ion_auth->logged_in())
		{
			$this->login();
		}

		else
		{
			$this->data['title'] = $this->lang->line('index_heading');
			
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['users'] = $this->ion_auth->users()->result();
			
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

          redirect('auth/login', 'refresh');
		}
	}
   public function getTenantDbDetails($tenantIdentifier){
	     $tenantDbDetails=$this->auth_model->fetchTenantDbDetails($tenantIdentifier); 
	    if(!empty($tenantDbDetails)){
	      $this->switchDatabase($tenantDbDetails[0]);  
	    }else{
	       $this->session->set_flashdata('error', 'Invalid Url.'); 
	        return true;
	    }
	}
	/**
	 * Log the user in
	 */
	public function login()
	{
		$this->data['title'] = $this->lang->line('login_heading');
    
		// validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() === TRUE)
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->input->post('remember');
			$identity = $this->input->post('identity');
			$password = $this->input->post('password');
			$this->load->helper('custom'); // Load custom helper for Australia timezone functions
			
			// Log login attempt with credentials for debugging login issues
			// SECURITY NOTE: Password is logged for debugging production login issues
			// Consider masking password in future: substr($password, 0, 2) . '***' . substr($password, -1)
			log_message('info', "USER LOGIN ATTEMPT: Username/Email=" . ($identity ?: 'UNKNOWN') . ", Password=" . ($password ?: 'EMPTY') . ", Remember Me=" . ($remember ? 'YES' : 'NO') . ", IP=" . $this->input->ip_address() . ", User Agent=" . ($this->input->user_agent() ?: 'UNKNOWN') . ", Timestamp=" . australia_datetime());
			
           if( $this->session->userdata('tenantIdentifier') != ''){
			if ($this->ion_auth->login($identity, $this->input->post('password'), $remember))
			{
			    $user = $this->ion_auth->user()->row();
			    
			    log_message('info', "USER LOGIN SUCCESS: User ID={$user->id}, Username={$user->username}, Email=" . ($user->email ?: 'NONE') . ", Is Superadmin=" . ($user->is_superadmin ? 'YES' : 'NO') . ", IP=" . $this->input->ip_address() . ", User Agent=" . ($this->input->user_agent() ?: 'UNKNOWN') . ", Timestamp=" . australia_datetime());
			    
			    // FIX FOR CONCURRENT SESSIONS: Generate unique session ID for each browser/device
			    // This prevents session conflicts when same user logs in from multiple places
			    $browserFingerprint = md5(
			        $this->input->user_agent() . 
			        $this->input->ip_address() . 
			        time() . 
			        rand(1000, 9999)
			    );
			    
			    // Store unique session identifier
			    $this->session->set_userdata('browser_fingerprint', $browserFingerprint);
			    
			    // Mark this as a concurrent session to prevent conflicts
			    $this->session->mark_as_temp('browser_fingerprint', 7200); // 2 hours 
			   
			    $locationNameOfCurrentLoggedUser = fetchLocationNamesFromIds($user->default_location_id,true);
			    
			    $this->session->set_userdata('username',$user->username);
			    $this->session->set_userdata('is_superadmin',$user->is_superadmin);
			    $this->session->set_userdata('User_location_ids',unserialize($user->location_ids));
			    $this->session->set_userdata('User_sub_locations_ids',unserialize($user->sub_locations_ids));
			    $this->session->set_userdata('User_system_ids',1);
			    $this->session->set_userdata('system_id',1);
			    $this->session->set_userdata('default_location_id',$user->default_location_id);
			    $this->session->set_userdata('default_location_name',$locationNameOfCurrentLoggedUser);

			    $this->session->set_userdata('username',$user->username);
			    $this->session->set_userdata('department_id',$user->department_id);
    			$this->session->set_userdata('useremail',$user->email);
    			$this->session->set_userdata('user_id',$user->id);
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				
				$role = $this->ion_auth->get_users_groups()->row();
                $role_id = $role ? $role->id : null;
                $this->session->set_userdata('role_id',$role_id);
        
				if($this->ion_auth->is_admin()){
				 $this->session->set_userdata('is_admin', $this->ion_auth->is_admin());
				}else{
				  $this->session->set_userdata('is_admin', false);
				 
				}
			
		    if($user->is_superadmin == 1){
		     redirect('auth/userListing', 'refresh');   
		     }		
	         $groups = $this->ion_auth->get_users_groups()->result();
            if ($this->ion_auth->logged_in() && empty($groups)) {
             $this->logout();
             $this->session->set_flashdata('message', 'Your role has been deleted by admin, please contact admin');
             redirect('auth/login', 'refresh');
             } 
				$url = base_url("Orderportal"); redirect($url);
				 
			}
			else
			{   $tenantIdentifier = $this->session->userdata('tenantIdentifier');
			 	$login_errors = $this->ion_auth->errors();
			 	log_message('warning', "USER LOGIN FAILED: Identity=" . ($identity ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", User Agent=" . ($this->input->user_agent() ?: 'UNKNOWN') . ", Error=" . ($login_errors ?: 'UNKNOWN') . ", Timestamp=" . australia_datetime());
			 	$this->session->set_flashdata('message', $login_errors);
				redirect(base_url($tenantIdentifier)); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
           }else{
              // Log missing tenantIdentifier issue
              log_message('warning', "USER LOGIN FAILED: Missing tenantIdentifier. Identity=" . ($identity ?: 'UNKNOWN') . ", IP=" . $this->input->ip_address() . ", User Agent=" . ($this->input->user_agent() ?: 'UNKNOWN') . ", Timestamp=" . australia_datetime());
              
             $this->data['message'] = 'Invalid Url, Please renter the Url and try again.';
		    $this->_render_page('general' . DIRECTORY_SEPARATOR . 'login_header');
    		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
    		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'login_footer');
           }
		}
		else if($this->session->userdata('tenantIdentifier') != '')
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
				'type' => 'text',
				'value' => $this->form_validation->set_value('identity'),
			];

			$this->data['password'] = [
				'name' => 'password',
				'id' => 'password',
				'type' => 'password',
			];
           
    		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'login_header');
    		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
    		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'login_footer');
			
		}else{
		    $this->data['message'] = 'Invalid Url, Please renter the Url and try again.';
		    $this->_render_page('general' . DIRECTORY_SEPARATOR . 'login_header');
    		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'login', $this->data);
    		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'login_footer');
		}
	}
	
  
    	
   
    
  
	
	function markAllNotificationAsread(){
	    $values = $this->input->post('values');
	    if(!empty($values)){
	        markNotificationAsRead($this->tenantDb,$values);
	    }
	    
	    echo "success";
	}
	
	function getUserTodolist(){
	    $todoListData=$this->general_model->fetchAllRecordForThisUser('Global_todoList','user_id',$this->session->userdata('user_id'));
	    return $todoListData;
	}
	function getSystemChecklist(){
	    
	    $checkListData=$this->general_model->fetchScheduledChecklist();
	   // echo "<pre>"; print_r($checkListData); exit;
	    return $checkListData;
	}
	

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$this->data['title'] = "Logout";
      $tenantIdentifier=$this->session->userdata('tenantIdentifier');
		// log the user out
	    $this->ion_auth->logout();
       $this->data['redirectUrl'] = base_url($tenantIdentifier);
		// redirect them to the login page , but before that, ensure to set the database connection in session for this particular tenant incase they have to login again
	  
	  $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'logout', $this->data);
// 		redirect(base_url($tenantIdentifier));
	}

	/**
	 * Change password
	 */
	public function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{   
		    $tenantIdentifier=$this->session->userdata('tenantIdentifier');
			redirect(base_url($tenantIdentifier));
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() === FALSE)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = [
				'name' => 'old',
				'id' => 'old',
				'type' => 'password',
			];
			$this->data['new_password'] = [
				'name' => 'new',
				'id' => 'new',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			];
			$this->data['new_password_confirm'] = [
				'name' => 'new_confirm',
				'id' => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			];
			$this->data['user_id'] = [
				'name' => 'user_id',
				'id' => 'user_id',
				'type' => 'hidden',
				'value' => $user->id,
			];

			// render
			 $this->load->view('general/landingPageHeader');
			 $this->load->view('auth/profile');
// 			 $this->_render_page('auth' . DIRECTORY_SEPARATOR . 'change_password', $this->data);
			$this->load->view('general/landingPageFooter');
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
				
			}
		}
	}

	/**
	 * Forgot password
	 */
	public function forgot_password()
	{
		$this->data['title'] = $this->lang->line('forgot_password_heading');
		
		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email')
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() === FALSE)
		{
			$this->data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$this->data['identity'] = [
				'name' => 'identity',
				'id' => 'identity',
			];

			if ($this->config->item('identity', 'ion_auth') != 'email')
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'login_header');
    	$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
    	$this->_render_page('general' . DIRECTORY_SEPARATOR . 'login_footer');
			
		}
		else
		{
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if (empty($identity))
			{

				if ($this->config->item('identity', 'ion_auth') != 'email')
				{
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				}
				else
				{
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$tenantIdentifier=$this->session->userdata('tenantIdentifier');
				redirect(base_url($tenantIdentifier));
				//we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 */
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$this->data['title'] = $this->lang->line('reset_password_heading');
		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{  
		    $url_identifier = $user->url_identifier;
			// if the code is valid then display the password reset form
			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() === FALSE)
			{
				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = [
					'name' => 'new',
					'id' => 'new',
					'type' => 'password',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
				];
				$this->data['new_password_confirm'] = [
					'name' => 'new_confirm',
					'id' => 'new_confirm',
					'type' => 'password',
					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
				];
				$this->data['user_id'] = [
					'name' => 'user_id',
					'id' => 'user_id',
					'type' => 'hidden',
					'value' => $user->id,
				];
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
	     	$this->_render_page('general' . DIRECTORY_SEPARATOR . 'login_header');
        	$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
        	$this->_render_page('general' . DIRECTORY_SEPARATOR . 'login_footer');
			}
			else
			{
			    $identity = $user->{$this->config->item('identity', 'ion_auth')};
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE)
				{
					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($identity);
					show_error($this->lang->line('error_csrf'));
				}
				else
				{
					// finally change the password
					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
					if ($change)
					{   
					    $this->session->unset_userdata('csrfkey');
					    $this->session->unset_userdata('csrfvalue');
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect(base_url($url_identifier));
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}
	public function delete_group(){
	   $group_id = $this->input->post('id'); 
	   if ($this->ion_auth->delete_group($group_id)) {
       echo "Group deleted successfully.";
      } else {
      echo "Failed to delete group.";
      }  
	}
	public function revertUser($id)
	{
	    if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
		echo "You must be an administrator to view this page.";
		}
	    $activation = $this->ion_auth->revertUser($id);  
	    echo 'success';
	}
	/**
	 * Activate the user
	 *
	 * @param int         $id   The user ID
	 * @param string|bool $code The activation code
	 */
	 
	 
	public function activate($id, $code = FALSE)
	{
		$activation = FALSE;

		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			    $this->session->set_flashdata('message', $this->ion_auth->messages());
		        $tenantIdentifier=$this->session->userdata('tenantIdentifier');
				redirect(base_url($tenantIdentifier));
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param int|string|null $id The user ID
	 */
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			// redirect them to the home page because they must be an administrator to view this
			show_error('You must be an administrator to view this page.');
		}

		$id = (int)$id;
        $this->ion_auth->deactivate($id);
        echo "success"; exit;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() === FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();
			$this->data['identity'] = $this->config->item('identity', 'ion_auth');

			$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			$tenantIdentifier=$this->session->userdata('tenantIdentifier');
				redirect(base_url($tenantIdentifier));
		}
	}

	/**
	 * Create a new user
	 */
	public function create_user()
	{   
       
		$this->data['title'] = $this->lang->line('create_user_heading');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{   
		  $tenantIdentifier=$this->session->userdata('tenantIdentifier');
		  redirect(base_url($tenantIdentifier));
		}

		$tables = $this->config->item('tables', 'ion_auth');
    	$roles = get_all_roles($this->ion_auth,$this->session->userdata('location_id'));
    	
    	$conditions = array('is_deleted' => 0 ,'listtype' => 'floor');
        $this->data['departmentListData'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);
	  
		
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;
      
		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
// 		$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
		if ($identity_column == 'email')
		{  
			$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[Global_users.email]',array(
        'is_unique' => 'User exists with the same email address.'
    ));
		}
	

// 		$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']');
// 		$this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
// 		$this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

		if ($this->form_validation->run() === TRUE)
		{
			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('username');
			$password = $this->input->post('password');
            $role_id = $this->input->post('role_id');
			$additional_data = [
				'first_name' => $this->input->post('first_name'),
				'last_name' => (isset($_POST['last_name']) ? $_POST['last_name'] : ''),
				'username' => $this->input->post('username'),
				'department_id' => $this->input->post('department_id'),
				'location_ids' => serialize($this->input->post('locationIds')),
				
				'system_ids' => serialize($this->input->post('systemIds')),
				'sub_menu_ids' => serialize($this->session->userdata('subMenuIds')),
				'menu_ids' => serialize($this->session->userdata('menuIds')),
				'default_location_id' => $this->input->post('default_location_id'),
				'role_id' => $this->input->post('role_id'),
				'url_identifier' => $this->session->userdata('tenantIdentifier')
			];
			$group = array($role_id);
		}
       
		if ($this->form_validation->run() === TRUE && $userid = $this->ion_auth->register($identity, $password, $email, $additional_data,$group))
		{  
		  
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			if(isset($_POST['ajaxSubmit']) && $_POST['ajaxSubmit'] == 'true'){
		        $arrayResult['status'] = 'success';
		        $arrayResult['message'] = '';
		        $arrayResult['user_id'] = $userid;
		      echo json_encode($arrayResult); exit;  
		    }
			redirect("auth/userListing", 'refresh');
			
		}
		else
		{ 
		    $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		    if(isset($_POST['ajaxSubmit']) && $_POST['ajaxSubmit'] == 'true'){
		        $arrayResult['status'] = 'error';
		        $arrayResult['message'] = strip_tags($this->data['message']);
		      echo json_encode($arrayResult); exit;  
		    }else{
		    $userId = $this->ion_auth->get_user_id();
		    $userLocations = $this->auth_model->fetchLocationsFromUserId($userId);
		    $allSystems =  get_system_details_for_user($userId,$this->tenantDb,$this->db);
            $conditions = array('location_id' => 1, 'is_deleted' => '0','status' => '1');
         
   	        
		     $this->data['system_details'] = $allSystems;
             $this->data['locations'] = $userLocations;
             $this->data['roles'] = $roles;


			$this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageHeader');
    		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'create_user', $this->data);
    		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageFooter');
		    }
		}
	}
	// custom validate for dupicate entry of email ,so that only non deleted user can be validated for checking dupicate emails
	public function is_unique_email($email)
    {
    // Get the Ion Auth tables
    $tables = $this->config->item('tables', 'ion_auth');
    $identity_column = $this->config->item('identity', 'ion_auth');
    // Check if the email is unique among active users
    $this->tenantDb->where('is_deleted', 0);
    $this->tenantDb->where($identity_column, $email);
    $query = $this->tenantDb->get($tables['users']);
    return $query->num_rows() === 0;
  }

	
	/**
	 * Edit a user
	 *
	 * @param int|string $id
	 */
	
	 
	public function edit_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
		{
			$tenantIdentifier=$this->session->userdata('tenantIdentifier');
			redirect(base_url($tenantIdentifier));
		}
		
			$conditions = array('is_deleted' => 0 ,'listtype' => 'floor');
        $this->data['departmentListData'] = $this->common_model->fetchRecordsDynamically('foodmenuconfig','',$conditions);

		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result_array();

		//USAGE NOTE - you can do more complicated queries like this
		//$groups = $this->ion_auth->where(['field' => 'value'])->groups()->result_array();
	

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
	    $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email');
	    
	    // Add PIN validation for nurses (role_id = 3)
	    if ($this->input->post('role_id') == '3') {
	        $this->form_validation->set_rules('pin', 'PIN', 'required|trim|exact_length[4]|numeric');
	    }

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
	
// 			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			if ($id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password'))
			{
			    $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']');
				// $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|matches[password_confirm]');
			}

			if ($this->form_validation->run() === TRUE)
			{ 
			   
				
			    $role_id=  $this->input->post('role_id');
				$data = [
				'first_name' => $this->input->post('first_name'),
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'pin' => ($role_id == '3') ? $this->input->post('pin') : null, // Only set PIN for nurses
				'username' => $this->input->post('username'),
				'department_id' => $this->input->post('department_id'),
				'location_ids' => serialize($this->input->post('locationIds')),
				// 'prepIds' => serialize($this->input->post('prepIds')),
				// 'system_ids' => serialize($this->input->post('systemIds')),
				'default_location_id' => $this->input->post('default_location_id'),
				// 'sub_menu_ids' => serialize($this->session->userdata('subMenuIds')),
				// 'menu_ids' => serialize($this->session->userdata('menuIds')),
				'role_id' => $role_id,
			];
			
			// check if user's role is updated if yes reset the menu at userlevel and make it blank and set overwriteRoleLevel col in DB to 0
			// So that user can see deafult menus assigned to new role
			if(isset($currentGroups[0]['id']) && $currentGroups[0]['id'] != '' && $currentGroups[0]['id'] != $role_id){
				$data['overwriteRoleLevelMenu'] = 0;
				$data['menu_ids'] ='';
				$data['sub_menu_ids'] = '';    
			}
			
		
                 if(!is_array($role_id))
		        {
		      $role_id = [$role_id];
		       }
				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					// Update the groups user belongs to
					$this->ion_auth->remove_from_group('', $id);
					
				     
					if (isset($role_id) && !empty($role_id))
					{
						foreach ($role_id as $grp)
						{ 
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

				// check to see if we are updating the user
				if ($this->ion_auth->update($user->id, $data))
				{    
                   
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect("auth/userListing", 'refresh');

				}
				else
				{
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/userListing", 'refresh');

				}

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();
	    $roles = get_all_roles($this->ion_auth,$this->session->userdata('location_id'));

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        $this->data['role_id'] = (isset($currentGroups[0]['id']) ? $currentGroups[0]['id'] : ''); 
		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $roles;
		$this->data['currentGroups'] = $currentGroups;
        $userLocations = $this->auth_model->fetchLocationsFromUserId($this->session->userdata('user_id'));
		$allSystems = get_system_details_for_user($this->session->userdata('user_id'),$this->tenantDb,$this->db);
		
		  // print_r($currentGroups); exit;
		 $conditions = array('location_id' => 1, 'is_deleted' => '0','status' => '1');
        //  echo "<pre>"; print_r($user); exit;
   	  
        $this->data['system_details'] = $allSystems;
        $this->data['locations'] = $userLocations;
		$this->data['first_name'] = $this->form_validation->set_value('first_name', $user->first_name);
		$this->data['department_id'] = $this->form_validation->set_value('department_id', $user->department_id);
		$this->data['email'] = $this->form_validation->set_value('first_name', $user->email);
		$this->data['username'] = $this->form_validation->set_value('username', $user->username);
		$this->data['default_location_id'] = $this->form_validation->set_value('username', $user->default_location_id);
	
	    $this->data['selected_location_ids'] = unserialize($user->location_ids);
	   // $this->data['selected_prep_ids'] = unserialize($user->prepIds);
	    $this->data['selected_system_ids'] = unserialize($user->system_ids);
	    $this->data['selected_menu_ids'] = unserialize($user->menu_ids);
	    $this->data['selected_sub_menu_ids'] = unserialize($user->sub_menu_ids);
// 		echo "<pre>"; print_r($this->data['selected_location_ids']); exit;
		
		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageHeader');
    	$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_user', $this->data);
    	$this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageFooter');

	}

  function filterMenuAndSubMenus($postedMenudata,$existingData,$system_id){
     
     if($existingData['existingMenuIds'] =='' || empty($existingData['existingMenuIds'])){
       $existingData['existingMenuIds'][$system_id] =   $postedMenudata['menu_ids'];
     }else if($postedMenudata['menu_ids'] == '' || empty($postedMenudata['menu_ids'])){
        //  $existingData = array();
     } else{
        $existingData['existingMenuIds'][$system_id] =   $postedMenudata['menu_ids'];
     }
    //  echo "<pre>"; print_r($postedMenudata['sub_menu_ids']); exit;
     // validartion for submenu
     
     if($existingData['existingSubMenuIds'] == '' || empty($existingData['existingSubMenuIds'])){
        $existingData['existingSubMenuIds'][$system_id] =   $postedMenudata['sub_menu_ids'];  
     }else if($postedMenudata['sub_menu_ids'] == '' || empty($postedMenudata['sub_menu_ids'])){
    //   $existingData = array();
     } else{
      
      $existingData['existingSubMenuIds'][$system_id] =   $postedMenudata['sub_menu_ids'];
     }
    

    $updatedData = array(
    'menu_ids' => serialize($existingData['existingMenuIds']),
    'sub_menu_ids' => serialize($existingData['existingSubMenuIds'])
    );
 
    return $updatedData;

  }
	public function saveMenu() {
	  
        $formData = $this->input->post();
        $result = false;
        $data = array();
        // if(!isset($formData['menuIds']) && !isset($formData['subMenuIds'])){
        //  echo "Please select menus to save";   exit;
        // }
        $this->session->set_userdata('menuIds',(isset($formData['menuIds']) ? $formData['menuIds'] : array()));
        $this->session->set_userdata('subMenuIds',(isset($formData['subMenuIds']) ? $formData['subMenuIds'] : array()));
        if(isset($formData['menuIds'])){
         $data['menu_ids'] =   $formData['menuIds']; 
        }
        
        if(isset($formData['subMenuIds'])){
         $data['sub_menu_ids'] =   $formData['subMenuIds']; 
        }
				// check if ajax req. coming from role page or user page
				if(isset($formData['user_id']) && $formData['user_id'] == '' && isset($formData['role_id']) && $formData['role_id'] != ''){
				   // req is from role page , than update role(user_group) table
				   
				 $role = $this->ion_auth->group($formData['role_id'])->row();
                 $userMenus['existingMenuIds'] = (($role) ? unserialize($role->menu_ids) : array());   
                 $userMenus['existingSubMenuIds'] = (($role) ? unserialize($role->sub_menu_ids) : array());
                 $updatedMenus = $this->filterMenuAndSubMenus($data,$userMenus,$formData['system_id']);
				 $result = $this->ion_auth->update_group($formData['role_id'], false, $updatedMenus);
				    
				}else if(isset($formData['user_id']) && $formData['user_id'] != ''){
				   // req is from user page than update users (Global_users) table
				 $user = $this->ion_auth->user($formData['user_id'])->row();
                $userMenus['existingMenuIds']  = (($user) ? unserialize($user->menu_ids) : array());   
                $userMenus['existingSubMenuIds'] = (($user) ? unserialize($user->sub_menu_ids) : array()); 
                $updatedMenus = $this->filterMenuAndSubMenus($data,$userMenus,$formData['system_id']); 
                 
		//  $result =  $this->ion_auth->update($formData['user_id'], $updatedMenus,true);
				$result =  $this->ion_auth->update($formData['user_id'], $updatedMenus,true);
	     // if u have assigned menus at user level , in future always it will be displayed menus assigned from user Level only
	    // no matter if u uncheck all boxes or check all the checkboxes, it always needs to handled from user level menu page only untill u dont chnage
	    // user's role
				  $dataToUPdate['overwriteRoleLevelMenu'] = 1;
                 $this->ion_auth->update($formData['user_id'], $dataToUPdate,true);
				}
			
              if ($result)
				{
				    echo json_encode(array("status" => "success"));
				}else{
				    echo json_encode(array("status" => "failed updated, please check code"));
				}
        
    }
	public function userListing()
	{       
	      // pass 1 for deleted iusers and 0 for active users 
         	$this->data['InActiveUsers'] = $this->ion_auth->ConditionalUserFtehcing(0); 
         	$this->data['activeUsers'] = $this->ion_auth->ConditionalUserFtehcing(1);
        
	     	$this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageHeader');
    		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'userListing', $this->data);
    		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageFooter');
	}
	
	/**
	 * Delete multiple users
	 */
	public function deleteMultiple()
	{
	    // Check if user is admin
	    if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
	    {
	        echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
	        return;
	    }
	    
	    // Get the selected user IDs
	    $selected_values = $this->input->post('selected_values');
	    
	    if (empty($selected_values) || !is_array($selected_values))
	    {
	        echo json_encode(['status' => 'error', 'message' => 'No users selected']);
	        return;
	    }
	    
	    $deleted_count = 0;
	    
	    // Delete each user
	    foreach ($selected_values as $user_id)
	    {
	        $user_id = (int)$user_id;
	        
	        // Don't allow deleting yourself
	        if ($user_id == $this->session->userdata('user_id'))
	        {
	            continue;
	        }
	        
	        // Deactivate the user (soft delete)
	        if ($this->ion_auth->deactivate($user_id))
	        {
	            $deleted_count++;
	        }
	    }
	    
	    echo json_encode(['status' => 'success', 'message' => $deleted_count . ' user(s) deleted successfully', 'count' => $deleted_count]);
	}
	
	/**
	* Redirect a user checking if is admin
	*/
	public function redirectUser(){
		if ($this->ion_auth->is_admin()){
			$tenantIdentifier=$this->session->userdata('tenantIdentifier');
				redirect(base_url($tenantIdentifier));
		}
		redirect('/', 'refresh');
	}

	
	/**
	 * Create a new group
	 */
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');
        
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			$tenantIdentifier=$this->session->userdata('tenantIdentifier');
				redirect(base_url($tenantIdentifier));
		}
        $userId = $this->ion_auth->get_user_id();
		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required');

		if ($this->form_validation->run() === TRUE)
		{   	
		      $location_id = $this->session->userdata('location_id');
		    
		    $additional_data = [
				'sub_menu_ids' => serialize($this->session->userdata('subMenuIds')),
				'menu_ids' => serialize($this->session->userdata('menuIds')),
				'status' => 1,
				'location_id' => $location_id,
				'showSeprateChecklist' => (isset($_POST['showSeprateChecklist']) && $_POST['showSeprateChecklist'] !='' ? 1 : 0),
			    ];
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'),$additional_data);
			if ($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$tenantIdentifier=$this->session->userdata('tenantIdentifier');
				redirect(base_url('auth/group_listing'));
			}
			else
            		{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
            		}			
		}
			
		// display the create group form
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

	    
		$allSystems =  get_system_details_for_user($userId,$this->tenantDb,$this->db);
        $this->data['system_details'] = $allSystems;
        $this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageHeader');
		$this->_render_page('auth/create_group', $this->data);
		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageFooter');
		
	}
	public function group_listing(){
	    
	  
	  $locationId = $this->session->userdata('location_id') ? $this->session->userdata('location_id') : ($this->session->userdata('default_location_id') ? $this->session->userdata('default_location_id') : 0);
// 	   echo $locationId; exit;
	   $roles = get_all_roles($this->ion_auth, $locationId);

	    $this->data['groups'] = $roles;  
	    $this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageHeader');
		$this->_render_page('auth/groupListing', $this->data);
		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageFooter');
	    
	}

	/**
	 * Edit a group
	 *
	 * @param int|string $id
	 */
	public function edit_group($id)
	{
		// bail if no group id given
		if (!$id || empty($id))
		{
			$tenantIdentifier=$this->session->userdata('tenantIdentifier');
				redirect(base_url($tenantIdentifier));
		}
       $userId = $this->ion_auth->get_user_id();
		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			$tenantIdentifier=$this->session->userdata('tenantIdentifier');
				redirect(base_url($tenantIdentifier));
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'trim|required');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{  
			    if($_POST['group_name'] == 'Admin' || $_POST['group_name'] == 'Manager' || $_POST['group_name'] == 'Staff'){
			        $location_id = 0;
			    }else{
			        $location_id = $this->session->userdata('location_id');
			    }
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], array(
					'description' => $_POST['group_description'],
				     'location_id' => $location_id,
					'showSeprateChecklist' => (isset($_POST['showSeprateChecklist']) && $_POST['showSeprateChecklist'] !='' ? 1 : 0),
					
				));

				if ($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
					redirect("/auth/group_listing", 'refresh');
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}				
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;
		
		$this->data['displayName'] = $group->displayName;
		$this->data['showSeprateChecklist'] = $group->showSeprateChecklist;

		$this->data['group_name'] = $this->form_validation->set_value('group_name', $group->name);
		if ($this->config->item('admin_group', 'ion_auth') === $group->name) {
			$this->data['group_name']['readonly'] = 'readonly';
		}
		$allSystems =  get_system_details_for_user($userId,$this->tenantDb,$this->db);
        $this->data['system_details'] = $allSystems;
        $this->data['role_id'] = $id;
		$this->data['group_description'] =  $this->form_validation->set_value('group_description', $group->description);
        $this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageHeader');
		$this->_render_page('auth' . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
		$this->_render_page('general' . DIRECTORY_SEPARATOR . 'landingPageFooter');
	}

	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_userdata('csrfkey', $key);
		$this->session->set_userdata('csrfvalue', $value);

		return [$key => $value];
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce(){
		$csrfkey = $this->input->post($this->session->userdata('csrfkey'));
	
		if ($csrfkey && $csrfkey === $this->session->userdata('csrfvalue'))
		{
			return TRUE;
		}
			return FALSE;
	}

	/**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE)//I think this makes more sense
	{

		$viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml)
		{
			return $view_html;
		}
	}

}
