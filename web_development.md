# 画面開発　環境構築

## database
1. dockerコンテナ立ち上げ
2. コンテナ内で `yum install -y mariadb-server`
3. mariadbをコンテナ起動で自動的に立ち上がるようにする

    `systemctl enable mariadb`

4. mariadbサービスの起動

    `systemctl start mariadb`

5. 外部アクセスを許可するユーザーを作成して権限を与える（以下のようなエラーが出た時に対応）

`Host 'web.docker_default' is not allowed to connect to this MariaDB server'`

対象ユーザの全てのホストからのアクセスを許可する

```
CREATE USER '[mysql user name]' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON *.* TO '[mysql user name]'@'%' WITH GRANT OPTION;
```