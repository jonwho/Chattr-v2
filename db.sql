--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: post; Type: TABLE; Schema: public; Owner: chattr; Tablespace: 
--

CREATE TABLE post (
    id integer NOT NULL,
    message character varying(150) NOT NULL,
    post_ref character varying(10),
    posttime timestamp(0) without time zone DEFAULT ('now'::text)::timestamp(0) without time zone
);


ALTER TABLE public.post OWNER TO chattr;

--
-- Name: post_id_seq; Type: SEQUENCE; Schema: public; Owner: chattr
--

CREATE SEQUENCE post_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.post_id_seq OWNER TO chattr;

--
-- Name: post_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chattr
--

ALTER SEQUENCE post_id_seq OWNED BY post.id;


--
-- Name: poster; Type: TABLE; Schema: public; Owner: chattr; Tablespace: 
--

CREATE TABLE poster (
    userid integer NOT NULL,
    username character varying(10) NOT NULL,
    password character varying(10) NOT NULL
);


ALTER TABLE public.poster OWNER TO chattr;

--
-- Name: poster_userid_seq; Type: SEQUENCE; Schema: public; Owner: chattr
--

CREATE SEQUENCE poster_userid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.poster_userid_seq OWNER TO chattr;

--
-- Name: poster_userid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: chattr
--

ALTER SEQUENCE poster_userid_seq OWNED BY poster.userid;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: chattr
--

ALTER TABLE ONLY post ALTER COLUMN id SET DEFAULT nextval('post_id_seq'::regclass);


--
-- Name: userid; Type: DEFAULT; Schema: public; Owner: chattr
--

ALTER TABLE ONLY poster ALTER COLUMN userid SET DEFAULT nextval('poster_userid_seq'::regclass);


--
-- Name: post_pkey; Type: CONSTRAINT; Schema: public; Owner: chattr; Tablespace: 
--

ALTER TABLE ONLY post
    ADD CONSTRAINT post_pkey PRIMARY KEY (id);


--
-- Name: poster_pkey; Type: CONSTRAINT; Schema: public; Owner: chattr; Tablespace: 
--

ALTER TABLE ONLY poster
    ADD CONSTRAINT poster_pkey PRIMARY KEY (userid);


--
-- Name: poster_username_key; Type: CONSTRAINT; Schema: public; Owner: chattr; Tablespace: 
--

ALTER TABLE ONLY poster
    ADD CONSTRAINT poster_username_key UNIQUE (username);


--
-- Name: post_ref; Type: FK CONSTRAINT; Schema: public; Owner: chattr
--

ALTER TABLE ONLY post
    ADD CONSTRAINT post_ref FOREIGN KEY (post_ref) REFERENCES poster(username);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

