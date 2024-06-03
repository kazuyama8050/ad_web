# 便利な設定、コマンドなど

## composer実行時にメモリエラーが発生する場合、以下のコマンドで一時的にメモリ制限を無制限とする
COMPOSER_MEMORY_LIMIT=-1
### 例
COMPOSER_MEMORY_LIMIT=-1 composer install

## Laravelクラス作成時、オートロード
新規のクラスを作成した場合、これをしないとロードされない場合がある
composer dump-autoload --optimize

以下のclassmapに該当クラスがあればOK
vendor/composer/autoload_classmap.php

## localeの問題解消
こんな警告が出た場合
```
bash: warning: setlocale: LC_ALL: cannot change locale (ja_JP.UTF-8)
/bin/sh: warning: setlocale: LC_ALL: cannot change locale (ja_JP.UTF-8)
```

localedef -f UTF-8 -i ja_JP ja_JP


## mysql データ削除時の外部キー制約一時解除
制約解除
```
SET foreign_key_checks = 0;
```

外部キー制約有効
```
SET foreign_key_checks = 1;
```