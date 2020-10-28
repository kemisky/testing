<?php
/**
 * AGS Class
 * 
 * This is testing for git commit
 * djdlld
 * 
 * @package AGS
 * @author Mike Yeung
 * @copyright (c) 2020, Cloud Design Limited
 */
class Ags {
    
    public function index ()
    {
        $src_folder = "source/";
        $out_folder = "output/";
        
        //$this->scanning($src_folder, $out_folder);
        
        if ($_POST['submit'])
        {
			unset($_POST['submit']);
			$this->scanning($src_folder, $out_folder, $_POST);
		}
		else
		{
			echo "<form method='post'>
			<p>
				<label>_Ags_</label>
				<input name='_Ags_'>			
			</p>
			<p>
				<label>_ags_</label>
				<input name='_ags_'>			
			</p>
			<p>
				<label>_Pkg_</label>
				<input name='_Pkg_'>			
			</p>
			<p>
				<label>_pkg_</label>
				<input name='_pkg_'>			
			</p>
			<p>
				<input type='submit' name='submit'>			
			</p>
			</form>";
		}
        
    }
    
    public function scanning ($src_folder, $out_folder, $post_val)
    {
        // Replace Source & Replaced Output
        $src_strs = array(            
            '_Ags_', 
            '_ags_',
            '_Pkg_',
            '_pkg_'
        );
        /*
        var_dump($post_val);
        exit;
        
        foreach ($src_strs as $index)
        {
			$out_strs[$index] = $post_val[$index];
		}
		*/
        
        /*
        $out_strs = array(
            'Quotation_item', 
            'quotation_item',
            'Qir_pkg',
            'qir_pkg'
        );
        */
        
         
        $out_strs = array(
			$post_val['_Ags_'],
			$post_val['_ags_'],
			$post_val['_Pkg_'],
			$post_val['_pkg_']
        );    
          
        
        foreach (scandir($src_folder) as $item) 
        {
            if ( $item != '.' && $item != '..')
            {
                $new_folder = str_replace($src_strs, $out_strs, $item);
                
                $next_src_folder = $src_folder. $item. '/';
                $next_out_folder = $out_folder. $new_folder. '/';
                
                if (is_dir($next_src_folder))
                {
                    if (@mkdir($next_out_folder))
                    {
                        chmod($next_out_folder, 0777);
                    }
                    
                    $this->scanning($next_src_folder, $next_out_folder, $post_val);
                }
                else
                {  
                    
                    $data = str_replace($src_strs, $out_strs, file_get_contents($src_folder. $item));
                    
                    $new_file = str_replace($src_strs, $out_strs, $item);
                    $this->create_file($out_folder. $new_file, $data);
                }
            }
        }        
    }
    
    public function create_file($file, $data)
    {        
        $fp = fopen($file, "w") or die("Unable to open file!");           
        file_put_contents($file, $data);
        fclose($fp);
        
        // Set perms with chmod()
        chmod($file, 0777);
        return TRUE;        
    }    
    
}

$ags = new Ags();
$ags->index();
