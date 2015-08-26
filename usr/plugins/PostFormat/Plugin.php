<?php
/**
 * Typecho 文章形式
 * 
 * @package PostFormat 
 * @author mufeng
 * @version 1.0.0
 * @update: 2012.07.07
 * @link http://mufeng.me
 */
class PostFormat_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        $db = Typecho_Db::get();
        $prefix = $db->getPrefix();

        // contents 表中若无 format 字段则添加
        if (!array_key_exists('format', $db->fetchRow($db->select()->from('table.contents'))))
            $db->query("ALTER TABLE `".$prefix."contents` ADD `format` varchar(16) DEFAULT 'post'");
			
		//添加文章
        Typecho_Plugin::factory('admin/write-post.php')->option = array('PostFormat_Plugin', 'formatsSelect');       
		
		//编辑文章
		Typecho_Plugin::factory('Widget_Contents_Post_Edit')->write = array('PostFormat_Plugin', 'formatsSet');       

    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
		echo '<style type="text/css">p#format{padding:10px 0 10px 60px;line-height:2em}ul{border:none!important}code{margin: 0 2px;padding:2px 5px;white-space: nowrap;border: 1px solid #EAEAEA;background-color: #fff;border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;}</style><p id="format">本插件提供了9种文章形式:<br /><code>标准 post</code> <code>日志 aside</code> <code>相册 gallery</code> <code>链接 link</code> <code>引语 quote</code> <code>状态 status</code> <code>视频 video</code> <code>音频 audio</code> <code>聊天 chat</code></p><p id="format">使用方法:</p><div class="source" style="font-size:12px;padding-left:60px;"><span style="color: rgb(0, 0, 0); ">&lt;?</span><span style="color: rgb(0, 0, 0); ">php</span> <span style="color: rgb(0, 0, 128); font-weight: bold; ">while</span>(<span style="color: rgb(0, 0, 0); ">$this</span><span style="color: rgb(0, 0, 0); ">-&gt;</span><span style="color: rgb(255, 0, 0); ">next</span>())<span style="color: rgb(0, 0, 0); ">:</span> <span style="color: rgb(0, 0, 0); ">$format</span> <span style="color: rgb(0, 0, 0); ">=</span> <span style="color: rgb(0, 0, 0); ">PostFormat_Plugin</span><span style="color: rgb(0, 0, 0); ">::</span><span style="color: rgb(255, 0, 0); ">getFormat</span>();<span style="color: rgb(0, 128, 128); ">?&gt;</span><br> &nbsp; <span style="color: rgb(0, 128, 128); ">&lt;?php</span> <span style="color: rgb(0, 0, 128); font-weight: bold; ">if</span> (<span style="color: rgb(0, 0, 0); ">$format</span> <span style="color: rgb(0, 0, 0); ">==</span> <span style="color: rgb(0, 0, 255); ">&#39;post&#39;</span>) <span style="color: rgb(0, 0, 0); ">{</span> <span style="color: rgb(0, 128, 128); ">?&gt;</span><br><span style="color: rgb(0, 0, 0); "> &nbsp; &nbsp; &nbsp; // 一般文章形式</span><br> &nbsp; <span style="color: rgb(0, 128, 128); ">&lt;?php</span> <span style="color: rgb(0, 0, 0); ">}</span> <span style="color: rgb(0, 0, 128); font-weight: bold; ">elseif</span> (<span style="color: rgb(0, 0, 0); ">$format</span> <span style="color: rgb(0, 0, 0); ">==</span> <span style="color: rgb(0, 0, 255); ">&#39;status&#39;</span><span style="color: rgb(0, 0, 0); ">){</span> <span style="color: rgb(0, 128, 128); ">?&gt;</span><br><span style="color: rgb(0, 0, 0); "> &nbsp; &nbsp; &nbsp; // 状态 类似微博</span><br> &nbsp; <span style="color: rgb(0, 128, 128); ">&lt;?php</span> <span style="color: rgb(0, 0, 0); ">}</span> <span style="color: rgb(0, 0, 128); font-weight: bold; ">elseif</span> (<span style="color: rgb(0, 0, 0); ">$format</span> <span style="color: rgb(0, 0, 0); ">==</span> <span style="color: rgb(0, 0, 255); ">&#39;link&#39;</span><span style="color: rgb(0, 0, 0); ">){</span> <span style="color: rgb(0, 128, 128); ">?&gt;</span><br><span style="color: rgb(0, 0, 0); "> &nbsp; &nbsp; &nbsp; // 链接</span><br> &nbsp; <span style="color: rgb(0, 128, 128); ">&lt;?php</span> <span style="color: rgb(0, 0, 0); ">}</span><span style="color: rgb(0, 128, 128); ">?&gt;</span><br><span style="color: rgb(0, 128, 128); ">&lt;?php</span> <span style="color: rgb(0, 0, 128); font-weight: bold; ">endwhile</span>; <span style="color: rgb(0, 128, 128); ">?&gt;</span></div>';
		$formats = new Typecho_Widget_Helper_Form_Element_Checkbox('format', array('aside'=>'日志', 'gallery'=>'相册', 'link'=>'链接', 'quote'=>'引语', 'status'=>'状态', 'video'=>'视频', 'audio'=>'音频', 'chat'=>'聊天'),array(""),'选取支持的文章形式',_t('被选择的文章形式将会在编写文章时出现在选项里, 一项也不选择将会默认显示所有'));
		$form->addInput($formats->multiMode()); 
	}

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
     * 编辑文章页, 添加 "文章形式" 选项
     *
     *
     * @param string  $args 文章形式
     * @return void
     */
    public static function formatsSelect()
    {
		$options = Typecho_Widget::widget('Widget_Options');
		$formats = $options->plugin('PostFormat');
		$custom_format =  $formats->format;
		$regular_format = array('post'=>'标准', 'aside'=>'日志', 'gallery'=>'相册', 'link'=>'链接', 'quote'=>'引语', 'status'=>'状态', 'video'=>'视频', 'audio'=>'音频', 'chat'=>'聊天');
		if(count($custom_format)>0){
			$args = array('post'=>'标准');
			foreach($regular_format as $key=>$val){
				if(in_array($key,$custom_format)){
					$args[$key] = $val;
				}
			}
		}else{
			$args = array('post'=>'标准', 'aside'=>'日志', 'gallery'=>'相册', 'link'=>'链接', 'quote'=>'引语', 'status'=>'状态', 'video'=>'视频', 'audio'=>'音频', 'chat'=>'聊天');
		}
		if(isset($_GET['cid'])){
			$cid = $_GET['cid'];
			$db = Typecho_Db::get();
			$row = $db->fetchRow($db->select('format')->from('table.contents')->where('cid = ?', $cid));
			$format = $row['format'];
		}else{
			$format = "post";
		}
		$output = '';
		foreach( $args as $key => $value ){
			$check = $key == $format ? 'checked="checked"' :'';
			$output .= '<li><input type="radio" name="format" id="format-'.$key.'" value="'.$key.'" '.$check.'><label for="format-'.$key.'">'.$value.'</label></li>';
		}
		echo '<li><label class="typecho-label">形式</label><ul>'.$output.'</ul></li>';
    }
	
    /**
     * 提交文章, 设置文章形式
     *
     * 
     * @return void
     */
	public static function formatsSet($contents, $inst)
	{
		$db = Typecho_Db::get();
		Typecho_Widget::widget('Widget_Contents_Post_Edit')->to($post);	
		$cid = $post->cid;
		if($cid!=null){ // 文章已存在, 直接修改 format 字段
			$db->query($db->update('table.contents')->rows(array('format' => $_POST['format']))->where('cid = ?', $cid));
			return $contents;
		}else{ // 文章不存在, 新建文章
			$options = Typecho_Widget::widget('Widget_Options');
			
			if( $contents['title']!="" ){
				$contents['status'] = $_POST['do']== 'publish' ? 'publish':'draft';
				$cid = $post->insert($contents);

				/** 插入分类 */
				if (array_key_exists('category', $contents)) {
					$post->setCategories($cid, !empty($contents['category']) && is_array($contents['category']) ?
					$contents['category'] : array($options->defaultCategory), false, true);
				}

				/** 插入标签 */
				if (array_key_exists('tags', $contents)) {
					$post->setTags($cid, $contents['tags'], false, true);
				}

				/** 同步附件 */
				$post->attach($cid);
				
				/** 文章形式 */
				$db->query($db->update('table.contents')->rows(array('format' => $_POST['format']))->where('cid = ?', $cid));
				
				$post->fetchRow($post->select()->where('table.contents.cid = ?', $cid)->limit(1), array($post, 'push'));
				
				/** 新建提示 */
				$newPost = $db->fetchRow($post->select()->where('table.contents.cid = ?', $cid)->limit(1));
				$result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($newPost);
				$post->widget('Widget_Notice')->set('publish' == $result['status'] ?
				_t('文章 "<a href="%s">%s</a>" 已经发布', $result['permalink'], $result['title']) :
				_t('文章 "%s" 等待审核', $result['title']), NULL, 'success');

				/** 设置高亮 */
				$post->widget('Widget_Notice')->highlight($cid);
			}
			$post->response->redirect(Typecho_Common::url('manage-posts.php', $options->adminUrl));
			exit;
		}
	}

	/**
     * 输出文章形式
     *
     * 语法: PostFormat_Plugin::getFormat();
     *
     * @access public
     * @return void
     */
	public static function getFormat()
	{
        $db = Typecho_Db::get();
        $cid = Typecho_Widget::widget('Widget_Archive')->cid;
        $row = $db->fetchRow($db->select('format')->from('table.contents')->where('cid = ?', $cid));
		return $row['format'];
	}
}
