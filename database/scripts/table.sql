CREATE TABLE public.migrations
(
    id integer DEFAULT nextval('migrations_id_seq'::regclass) PRIMARY KEY NOT NULL,
    migration varchar(255) NOT NULL,
    batch integer NOT NULL
);

CREATE TABLE public.user_roles
(
    id integer DEFAULT nextval('user_roles_id_seq'::regclass) PRIMARY KEY NOT NULL,
    name varchar(128) NOT NULL,
    created_at timestamp(0),
    updated_at timestamp(0)
);
CREATE UNIQUE INDEX user_roles_name_unique ON public.user_roles (name);

CREATE TABLE public.users
(
    id integer DEFAULT nextval('users_id_seq'::regclass) PRIMARY KEY NOT NULL,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    email_verified_at timestamp(0),
    password varchar(255) NOT NULL,
    enabled boolean DEFAULT true NOT NULL,
    user_role_id integer NOT NULL,
    photo varchar(128),
    remember_token varchar(100),
    created_at timestamp(0),
    updated_at timestamp(0),
    CONSTRAINT users_user_roles_id_fk FOREIGN KEY (user_role_id) REFERENCES public.user_roles (id)
);
CREATE UNIQUE INDEX users_email_unique ON public.users (email);

CREATE TABLE public.password_resets
(
    email varchar(255) NOT NULL,
    token varchar(255) NOT NULL,
    created_at timestamp(0)
);
CREATE INDEX password_resets_email_index ON public.password_resets (email);

CREATE TABLE public.channels
(
    id integer DEFAULT nextval('channels_id_seq'::regclass) PRIMARY KEY NOT NULL,
    name varchar(128) NOT NULL,
    description text,
    created_at timestamp(0),
    updated_at timestamp(0),
    slug varchar(128)
);
CREATE UNIQUE INDEX channels_name_unique ON public.channels (name);

CREATE TABLE public.topics
(
    id integer DEFAULT nextval('topics_id_seq'::regclass) PRIMARY KEY NOT NULL,
    name varchar(128) NOT NULL,
    channel_id integer NOT NULL,
    description text,
    created_at timestamp(0),
    updated_at timestamp(0),
    slug varchar(128),
    CONSTRAINT topics_channels_id_fk FOREIGN KEY (channel_id) REFERENCES public.channels (id)
);
CREATE UNIQUE INDEX topics_name_uindex ON public.topics (name);

CREATE TABLE public.discussions
(
    id integer DEFAULT nextval('discussions_id_seq'::regclass) PRIMARY KEY NOT NULL,
    user_id integer NOT NULL,
    topic_id integer NOT NULL,
    title varchar(255) NOT NULL,
    slug varchar(255) NOT NULL,
    content text NOT NULL,
    views integer DEFAULT 0 NOT NULL,
    archived boolean DEFAULT false NOT NULL,
    created_at timestamp(0),
    updated_at timestamp(0),
    CONSTRAINT discussions_users_id_fk FOREIGN KEY (user_id) REFERENCES public.users (id),
    CONSTRAINT discussions_topics_id_fk FOREIGN KEY (topic_id) REFERENCES public.topics (id)
);

CREATE TABLE public.report_reasons
(
    id integer DEFAULT nextval('report_reasons_id_seq'::regclass) PRIMARY KEY NOT NULL,
    name varchar(128) NOT NULL,
    created_at timestamp(0),
    updated_at timestamp(0)
);
CREATE UNIQUE INDEX report_reasons_name_unique ON public.report_reasons (name);

CREATE TABLE public.topic_bookmarks
(
    id integer DEFAULT nextval('topic_bookmarks_id_seq'::regclass) PRIMARY KEY NOT NULL,
    user_id integer NOT NULL,
    topic_id integer NOT NULL,
    created_at timestamp(0),
    updated_at timestamp(0),
    CONSTRAINT topic_bookmarks_users_id_fk FOREIGN KEY (user_id) REFERENCES public.users (id),
    CONSTRAINT topic_bookmarks_topics_id_fk FOREIGN KEY (topic_id) REFERENCES public.topics (id)
);

CREATE TABLE public.discussion_bookmarks
(
    id integer DEFAULT nextval('discussion_bookmarks_id_seq'::regclass) PRIMARY KEY NOT NULL,
    user_id integer NOT NULL,
    discussion_id integer NOT NULL,
    created_at timestamp(0),
    updated_at timestamp(0),
    CONSTRAINT discussion_bookmarks_users_id_fk FOREIGN KEY (user_id) REFERENCES public.users (id),
    CONSTRAINT discussion_bookmarks_discussions_id_fk FOREIGN KEY (discussion_id) REFERENCES public.discussions (id)
);

CREATE TABLE public.discussion_reports
(
    id integer DEFAULT nextval('discussion_reports_id_seq'::regclass) PRIMARY KEY NOT NULL,
    user_id integer NOT NULL,
    discussion_id integer NOT NULL,
    content text,
    report_reason_id integer NOT NULL,
    created_at timestamp(0),
    updated_at timestamp(0),
    CONSTRAINT discussion_reports_users_id_fk FOREIGN KEY (user_id) REFERENCES public.users (id),
    CONSTRAINT discussion_reports_discussions_id_fk FOREIGN KEY (discussion_id) REFERENCES public.discussions (id),
    CONSTRAINT discussion_reports_report_reasons_id_fk FOREIGN KEY (report_reason_id) REFERENCES public.report_reasons (id)
);

CREATE TABLE public.replies
(
    id integer DEFAULT nextval('replies_id_seq'::regclass) PRIMARY KEY NOT NULL,
    user_id integer NOT NULL,
    discussion_id integer NOT NULL,
    content text NOT NULL,
    created_at timestamp(0),
    updated_at timestamp(0),
    CONSTRAINT replies_users_id_fk FOREIGN KEY (user_id) REFERENCES public.users (id),
    CONSTRAINT replies_discussions_id_fk FOREIGN KEY (discussion_id) REFERENCES public.discussions (id)
);

CREATE TABLE public.reply_downvotes
(
    id integer DEFAULT nextval('reply_downvotes_id_seq'::regclass) PRIMARY KEY NOT NULL,
    user_id integer NOT NULL,
    reply_id integer NOT NULL,
    created_at timestamp(0),
    updated_at timestamp(0),
    CONSTRAINT reply_downvotes_users_id_fk FOREIGN KEY (user_id) REFERENCES public.users (id),
    CONSTRAINT reply_downvotes_replies_id_fk FOREIGN KEY (reply_id) REFERENCES public.replies (id)
);

CREATE TABLE public.reply_reports
(
    id integer DEFAULT nextval('reply_reports_id_seq'::regclass) PRIMARY KEY NOT NULL,
    user_id integer NOT NULL,
    reply_id integer NOT NULL,
    content text,
    report_reason_id integer NOT NULL,
    created_at timestamp(0),
    updated_at timestamp(0),
    CONSTRAINT reply_reports_users_id_fk FOREIGN KEY (user_id) REFERENCES public.users (id),
    CONSTRAINT reply_reports_replies_id_fk FOREIGN KEY (reply_id) REFERENCES public.replies (id),
    CONSTRAINT reply_reports_report_reasons_id_fk FOREIGN KEY (report_reason_id) REFERENCES public.report_reasons (id)
);

CREATE TABLE public.reply_upvotes
(
    id integer DEFAULT nextval('reply_upvotes_id_seq'::regclass) PRIMARY KEY NOT NULL,
    user_id integer NOT NULL,
    reply_id integer NOT NULL,
    created_at timestamp(0),
    updated_at timestamp(0),
    CONSTRAINT reply_upvotes_users_id_fk FOREIGN KEY (user_id) REFERENCES public.users (id),
    CONSTRAINT reply_upvotes_replies_id_fk FOREIGN KEY (reply_id) REFERENCES public.replies (id)
);